<style>
    .olh-report-header {
        margin: 0 0 8px 0;
        width: 100%;
        font-family: DejaVu Sans, sans-serif;
    }

    .olh-logo-table {
        border-collapse: collapse;
        table-layout: fixed;
        width: 100%;
    }

    .olh-logo-cell {
        padding: 0 10px;
        text-align: center;
        vertical-align: middle;
    }

    .olh-logo-left img {
        height: 70px;
    }

    .olh-logo-right img {
        height: 55px;
    }

    .olh-core-values {
        border-bottom: 1.5px solid #000;
        color: #000;
        font-size: 7.5px;
        padding: 4px 0 5px;
        text-align: center;
    }
</style>

<table class="olh-report-header">
    <tr>
        <td class="olh-logo-cell olh-logo-left">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/slsu.png'))) }}" alt="SLSU Logo">
        </td>
        <td class="olh-logo-cell olh-logo-right">
            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('image/bagong_pilipinas.jpeg'))) }}" alt="Bagong Pilipinas Logo">
        </td>
    </tr>
    <tr>
        <td class="olh-core-values" colspan="2">
            Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality
        </td>
    </tr>
</table>
