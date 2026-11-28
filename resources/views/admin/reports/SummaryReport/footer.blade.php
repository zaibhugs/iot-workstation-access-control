<style>
    .olh-report-footer {
        border-collapse: collapse;
        border-top: 1.5px solid #000;
        margin-top: 10px;
        table-layout: fixed;
        width: 100%;
        font-family: DejaVu Sans, sans-serif;
    }

    .olh-footer-page {
        color: #64748b;
        font-size: 7px;
        padding-top: 8px;
        text-align: left;
        vertical-align: middle;
        width: 30%;
    }

    .olh-footer-logos {
        padding-top: 8px;
        text-align: right;
        vertical-align: middle;
        width: 70%;
    }

    .olh-footer-logos img {
        margin-left: 18px;
        vertical-align: middle;
    }

    .olh-footer-qs {
        height: 42px;
    }

    .olh-footer-iso {
        height: 38px;
    }
</style>

<table class="olh-report-footer">
    <tr>
        <td class="olh-footer-page">
            Page {{ $pageNumber ?? 1 }} of {{ $totalPages ?? 1 }}
        </td>
        <td class="olh-footer-logos">
            <img class="olh-footer-qs" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/qs_rating.png'))) }}" alt="QS Stars Rated Good">
            <img class="olh-footer-iso" src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('image/socotec.jpg'))) }}" alt="SOCOTEC ISO 9001">
        </td>
    </tr>
</table>
