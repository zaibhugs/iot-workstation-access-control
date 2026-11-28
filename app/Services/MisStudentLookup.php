<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Looks up one RFID card in the university MIS.
 *
 * The simulated LibraryApi now answers with the official UISA column names
 * (StudentNo, LastName, FirstName, MiddleName, Sex, Course, CardNo). The
 * older camelCase names are still accepted so existing deployments keep
 * working while the real UISA endpoint is wired in.
 */
class MisStudentLookup
{
    public const CODE_CARD_NOT_REGISTERED = 'card_not_registered';

    public const CODE_DATABASE_UNAVAILABLE = 'student_database_unavailable';

    public const CODE_DATABASE_CONFIGURATION = 'student_database_configuration_error';

    public const CODE_DATABASE_UNEXPECTED_RESPONSE = 'student_database_unexpected_response';

    public function __construct(private MisSettings $settings) {}

    /**
     * @return array{0: array<string, string>|null, 1: string|null, 2: string|null}
     *                                                                              [student, reason, code]. A null student always has a reason.
     */
    public function lookup(string $cardId): array
    {
        $timeout = $this->settings->timeout();
        $url = $this->settings->endpointFor($cardId);

        try {
            $request = Http::timeout($timeout)->acceptJson();

            $misKey = $this->settings->apiKey();
            if ($misKey !== '') {
                $request = $request->withHeaders(['X-API-Key' => $misKey]);
            }

            $response = $request->get($url);

            if ($response->notFound()) {
                return [null, 'Card is not registered in the university MIS.', self::CODE_CARD_NOT_REGISTERED];
            }

            if ($response->unauthorized() || $response->forbidden()) {
                return [null, 'Student Database rejected the API key.', self::CODE_DATABASE_CONFIGURATION];
            }

            if (! $response->successful()) {
                return [
                    null,
                    'Student Database returned an unexpected response (HTTP '.$response->status().').',
                    self::CODE_DATABASE_UNEXPECTED_RESPONSE,
                ];
            }

            $data = $this->unwrap($response->json() ?? []);

            if (! is_array($data)) {
                return [null, 'Student Database returned an unexpected response.', self::CODE_DATABASE_UNEXPECTED_RESPONSE];
            }

            return [[
                'cardId' => (string) ($this->pick($data, ['CardNo', 'cardNo', 'cardId', 'CardId']) ?? $cardId),
                'studentNumber' => (string) ($this->pick($data, ['StudentNo', 'studentNo', 'studentNumber', 'StudentNumber']) ?? ''),
                'firstName' => (string) ($this->pick($data, ['FirstName', 'firstName']) ?? ''),
                'lastName' => (string) ($this->pick($data, ['LastName', 'lastName']) ?? ''),
                'middleName' => (string) ($this->pick($data, ['MiddleName', 'middleName']) ?? ''),
                'course' => (string) ($this->pick($data, ['Course', 'course']) ?? ''),
                'sex' => (string) ($this->pick($data, ['Sex', 'sex', 'Gender', 'gender']) ?? ''),
            ], null, null];
        } catch (\Throwable $ex) {
            Log::warning('Student database lookup failed.', [
                'url' => $url,
                'error' => $ex->getMessage(),
            ]);

            $message = $ex->getMessage();
            $detail = 'connection failed';
            if (str_contains($message, 'cURL error 28') || str_contains($message, 'timed out')) {
                $detail = 'connection timed out';
            } elseif (str_contains($message, 'cURL error 6') || str_contains($message, 'Could not resolve host')) {
                $detail = 'host could not be resolved';
            } elseif (str_contains($message, 'cURL error 60') || str_contains($message, 'SSL')) {
                $detail = 'SSL/certificate error';
            } elseif (str_contains($message, 'cURL error 7') || str_contains($message, 'Connection refused')) {
                $detail = 'connection refused';
            }

            return [null, 'Student Database is currently unavailable ('.$detail.').', self::CODE_DATABASE_UNAVAILABLE];
        }
    }

    /**
     * Accept either a plain object, a {data: {...}} / {student: {...}} wrapper,
     * or a one-item list. Real MIS gateways often wrap their payload.
     *
     * @param  array<mixed>  $data
     * @return array<mixed>
     */
    private function unwrap(array $data): array
    {
        if (isset($data['data']) && is_array($data['data'])) {
            return $data['data'];
        }

        if (isset($data['student']) && is_array($data['student'])) {
            return $data['student'];
        }

        if ($data !== [] && array_is_list($data) && is_array($data[0] ?? null)) {
            return $data[0];
        }

        return $data;
    }

    /**
     * @param  array<mixed>  $data
     * @param  list<string>  $keys
     */
    private function pick(array $data, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $data) && $data[$key] !== null) {
                return $data[$key];
            }
        }

        return null;
    }
}
