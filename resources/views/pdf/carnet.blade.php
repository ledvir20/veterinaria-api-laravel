<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carnet Veterinario MPH</title>
    <style>
        @page { margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 20px; }

        /* Contenedor CR80 */
        .carnet-container {
            width: 85.6mm;
            height: 53.98mm;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ccc;
            position: relative;
        }

        :root { --mph-red: #7e1616; --mph-red-light: #a32a2a; }

        /* Header */
        .header-table { width: 100%; background-color: #7e1616; color: white; border-collapse: collapse; }
        .header-table td { padding: 3px 5px; vertical-align: middle; }
        .logo-cell { width: 30px; text-align: center; }
        .header-text-cell { text-align: left; }
        .header-title { font-size: 8px; font-weight: bold; margin: 0; text-transform: uppercase; line-height: 1; }
        .header-subtitle { font-size: 5px; margin: 2px 0 0 0; text-transform: uppercase; opacity: 0.9; }

        /* Cuerpo */
        .main-content-table { width: 100%; border-collapse: collapse; table-layout: fixed; margin-top: 0; }
        .left-column { width: 30%; vertical-align: top; padding: 5px 2px; text-align: center; background-color: #f9f9f9; border-right: 1px dotted #ccc; }
        .right-column { width: 70%; vertical-align: top; padding: 5px 8px; }

        /* Foto y QR */
        .photo-box { width: 50px; height: 60px; background-color: #eee; border: 1px solid #7e1616; margin: 0 auto 4px auto; position: relative; }
        .photo-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 6px; color: #999; }
        .dni-label { font-size: 5px; color: #7e1616; font-weight: bold; }
        .dni-value { font-size: 8px; font-weight: bold; margin-bottom: 4px; color: #000; }

        /* Datos */
        .field-row { margin-bottom: 3px; }
        .label { font-size: 5px; color: #666; font-weight: bold; display: block; text-transform: uppercase; }
        .value { font-size: 9px; color: #000; font-weight: bold; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        /* Resalte Propietario */
        .highlight-box { background-color: #a32a2a; color: white; padding: 3px; border-radius: 3px; margin-top: 3px; }
        .highlight-box .label { color: #ffcccc; }
        .highlight-box .value { color: white; white-space: normal; line-height: 1.1; font-size: 8px;}

        .footer-stripe { position: absolute; bottom: 0; left: 0; width: 100%; height: 4px; background-color: #7e1616; }
    </style>
</head>
<body>

    <div class="carnet-container">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ public_path('images/logo_mph.png') }}" width="25" style="display:block;">
                </td>
                <td class="header-text-cell">
                    <div class="header-title">MUNICIPALIDAD PROV. HUAMANGA</div>
                    <div class="header-subtitle">REGISTRO VETERINARIO MUNICIPAL</div>
                </td>
            </tr>
        </table>

        <table class="main-content-table">
            <tr>
                <td class="left-column">
                    <div class="photo-box">
                        <div class="photo-text">FOTO</div>
                    </div>

                    <div class="dni-label">N° REGISTRO</div>
                    <div class="dni-value">{{ $mascota->dni_mascota }}</div>

                    <img src="data:image/svg+xml;base64, {{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->margin(0)->generate($mascota->dni_mascota)) }}"
                         width="40" height="40">
                </td>

                <td class="right-column">
                    <div class="field-row">
                        <span class="label">NOMBRE DE LA MASCOTA</span>
                        <span class="value" style="font-size: 10px;">{{ strtoupper($mascota->nombre) }}</span>
                    </div>

                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 60%; padding: 0;">
                                <span class="label">ESPECIE / RAZA</span>
                                <span class="value">{{ $mascota->especie }}</span>
                                <span class="value" style="font-size: 7px; font-weight: normal;">
                                    {{ \Illuminate\Support\Str::limit($mascota->raza ?? 'MESTIZO', 16) }}
                                </span>
                            </td>
                            <td style="width: 40%; padding: 0;">
                                <span class="label">SEXO / NAC.</span>
                                <span class="value">{{ $mascota->sexo }}</span>
                                <span class="value" style="font-size: 7px;">
                                    {{ $mascota->fecha_nacimiento ? date('d/m/y', strtotime($mascota->fecha_nacimiento)) : 'NO REG.' }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="field-row" style="margin-top: 3px;">
                        <span class="label">COLOR / SEÑAS</span>
                        <span class="value" style="font-size: 8px;">
                            {{ \Illuminate\Support\Str::limit($mascota->color ?? '---', 20) }}
                        </span>
                    </div>

                    <div class="highlight-box">
                        <span class="label">PROPIETARIO RESPONSABLE</span>
                        <span class="value">
                            {{ strtoupper(optional($mascota->dueno)->nombres ?? 'SIN REGISTRO') }}
                            {{ strtoupper(optional($mascota->dueno)->apellidos ?? '') }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer-stripe"></div>
    </div>

</body>
</html>
