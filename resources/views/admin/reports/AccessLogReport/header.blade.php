<style>
    * {
        box-sizing: border-box;
    }

    .olh-report-header {
        border-collapse: collapse;
        font-family: Aptos, DejaVu Sans, sans-serif;
        margin: 0 auto;
        padding-top: 0;
        width: 86%;
    }

    .olh-logos-row {
        border-collapse: separate;
        border-spacing: 18px 0;
        margin-bottom: 0;
        margin-left: auto;
        margin-right: auto;
    }

    .olh-logos-row td {
        text-align: center;
        vertical-align: middle;
    }

    .slsu-logo {
        height: 90px;
        width: auto;
    }

    .bagong-pilipinas-logo {
        height: 70px;
        position: relative;
        top: -8px;
        width: auto;
    }

    .core-values-cell {
        padding: 0;
    }

    .core-values-box {
        border-bottom: 1.5px solid #000;
        line-height: 1;
        padding-bottom: 2px;
        position: relative;
        text-align: center;
        top: -8px;
        width: 100%;
    }

    .core-values-text {
        color: #000;
        font-size: 8px;
        line-height: 1;
        white-space: nowrap;
    }
</style>

<table class="olh-report-header">
    <tr>
        <td>
            <table class="olh-logos-row">
                <tr>
                    <td>
                        <img class="slsu-logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/slsu.png'))) }}" alt="SLSU Logo">
                    </td>
                    <td>
                        <img class="bagong-pilipinas-logo" src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('image/bagong_pilipinas.jpeg'))) }}" alt="Bagong Pilipinas Logo">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="core-values-cell">
            <div class="core-values-box">
                <span class="core-values-text">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</span>
            </div>
        </td>
    </tr>
</table>
