<style>
    .olh-report-footer {
        border-collapse: collapse;
        border-top: 1.5px solid #000;
        font-family: Aptos, DejaVu Sans, sans-serif;
        margin: 0 auto;
        table-layout: fixed;
        width: 86%;
    }

    .olh-footer-cell {
        padding-top: 8px;
        vertical-align: middle;
    }

    .olh-footer-page {
        color: #64748b;
        font-size: 7px;
        text-align: left;
        width: 30%;
    }

    .olh-footer-logos {
        text-align: right;
        width: 70%;
    }

    .olh-footer-logos-row {
        border-collapse: separate;
        border-spacing: 25px 0;
        margin-left: auto;
    }

    .olh-footer-logos-row td {
        text-align: right;
        vertical-align: middle;
    }

    .qs-logo {
        height: 55px;
        width: auto;
    }

    .socotec-logo {
        height: 50px;
        width: auto;
    }
</style>

<table class="olh-report-footer">
    <tr>
        <td class="olh-footer-cell olh-footer-page">
            Page {{ $pageNumber ?? 1 }} of {{ $totalPages ?? 1 }}

            @if (($pageNumber ?? 1) === 1)
                <div class="page-note">
                    This document was generated automatically by the Workstation Access Control System.
                </div>
            @endif
        </td>
        <td class="olh-footer-cell olh-footer-logos">
            <table class="olh-footer-logos-row">
                <tr>
                    <td>
                        <img class="qs-logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/qs_rating.png'))) }}" alt="QS Stars Rated Good">
                    </td>
                    <td>
                        <img class="socotec-logo" src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('image/socotec.jpg'))) }}" alt="SOCOTEC ISO 9001">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
