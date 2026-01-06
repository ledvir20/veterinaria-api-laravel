<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carnet Veterinario MPH</title>
    <style>
        @page { margin: 0; padding: 0; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
        }

        /* --- CONTENEDOR PRINCIPAL (Tarjeta CR80) --- */
        .carnet-container {
            width: 85.6mm;
            height: 53.98mm;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ccc;
            position: relative; /* Clave para posicionar elementos absolutos */
        }

        /* --- COLORES --- */
        :root {
            --mph-red: #7e1616;
            --mph-red-light: #a32a2a;
        }

        /* --- HEADER --- */
        .header-box {
            width: 100%;
            height: 12mm; /* Altura fija para el header */
            background-color: #7e1616;
            color: white;
            position: absolute;
            top: 0;
            left: 0;
            padding: 2px 5px;
        }

        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: middle; }
        .logo-img { width: 28px; display: block; margin-right: 5px; }

        .header-title { font-size: 8px; font-weight: bold; margin: 0; text-transform: uppercase; line-height: 1; }
        .header-subtitle { font-size: 5px; margin: 1px 0 0 0; text-transform: uppercase; opacity: 0.9; }

        /* --- LÍNEA SEPARADORA (SOLUCIÓN DEFINITIVA) --- */
        .vertical-line {
            position: absolute;
            left: 31%; /* Posición exacta de la división */
            top: 13mm; /* Empieza justo debajo del header */
            bottom: 4mm; /* Termina justo antes del footer */
            width: 0;
            border-left: 1px dotted #ccc;
            z-index: 10;
        }

        /* --- CUERPO --- */
        .content-box {
            position: absolute;
            top: 13mm; /* Debajo del header */
            left: 0;
            width: 100%;
            bottom: 4mm; /* Encima del footer */
        }

        .main-table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .col-left {
            width: 31%;
            vertical-align: top;
            text-align: center;
            padding-top: 5px;
            background-color: #fcfcfc; /* Fondo sutil para diferenciar */
        }

        .col-right {
            width: 69%;
            vertical-align: top;
            padding: 4px 4px 4px 8px; /* Padding extra a la izquierda para separarse de la línea */
        }

        /* --- FOTO Y DNI --- */
        .photo-placeholder {
            width: 50px;
            height: 60px;
            background-color: #eee;
            border: 1px solid #7e1616;
            margin: 0 auto 3px auto;
            position: relative;
            border-radius: 2px;
        }
        .photo-text {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 5px; color: #999; font-weight: bold;
        }

        .dni-box { margin-bottom: 3px; }
        .dni-label { font-size: 4px; color: #7e1616; font-weight: bold; letter-spacing: 0.5px; }
        .dni-value { font-size: 8px; font-weight: bold; color: #000; }

        /* --- DATOS --- */
        .field-group { margin-bottom: 2px; }
        .label {
            font-size: 5px;
            color: #666;
            font-weight: bold;
            text-transform: uppercase;
            display: block;
            line-height: 1;
            margin-bottom: 1px;
        }
        .value {
            font-size: 8px;
            color: #000;
            font-weight: bold;
            display: block;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .value-sm { font-size: 7px; font-weight: normal; }

        /* --- OWNER BOX --- */
        .owner-box {
            background-color: #a32a2a;
            color: white;
            padding: 2px 4px;
            border-radius: 4px;
            margin-top: 3px;
        }
        .owner-box .label { color: #ffcccc; font-size: 4px; margin-bottom: 0; }
        .owner-box .value { color: white; font-size: 7px; white-space: normal; line-height: 1.1; }

        /* --- FOOTER --- */
        .footer-stripe {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4mm;
            background-color: #7e1616;
        }
    </style>
</head>
<body>

    <div class="carnet-container">

        <div class="header-box">
            <table class="header-table">
                <tr>
                    <td style="width: 35px;">
                        <img src="{{ public_path('images/logo_mph.png') }}" class="logo-img">
                    </td>
                    <td>
                        <div class="header-title">MUNICIPALIDAD PROV. HUAMANGA</div>
                        <div class="header-subtitle">REGISTRO VETERINARIO MUNICIPAL</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="vertical-line"></div>

        <div class="content-box">
            <table class="main-table">
                <tr>
                    <td class="col-left">
                        <div class="photo-placeholder">
                            <div class="photo-text">FOTO</div>
                        </div>

                        <div class="dni-box">
                            <div class="dni-label">N° REGISTRO</div>
                            <div class="dni-value">{{ $mascota->dni_mascota }}</div>
                        </div>

                        <div>
                            <img src="data:image/svg+xml;base64, {{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->margin(0)->generate($mascota->dni_mascota)) }}"
                                 width="35" height="35">
                        </div>
                    </td>

                    <td class="col-right">

                        <div class="field-group">
                            <span class="label">NOMBRE DE LA MASCOTA</span>
                            <span class="value" style="font-size: 10px;">{{ strtoupper($mascota->nombre) }}</span>
                        </div>

                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 2px;">
                            <tr>
                                <td style="width: 55%; vertical-align: top;">
                                    <span class="label">ESPECIE / RAZA</span>
                                    <span class="value">{{ $mascota->especie }}</span>
                                    <span class="value value-sm">{{ \Illuminate\Support\Str::limit($mascota->raza ?? 'MESTIZO', 14) }}</span>
                                </td>
                                <td style="width: 45%; vertical-align: top;">
                                    <span class="label">SEXO / NAC.</span>
                                    <span class="value">{{ $mascota->sexo }}</span>
                                    <span class="value value-sm">
                                        {{ $mascota->fecha_nacimiento ? date('d/m/y', strtotime($mascota->fecha_nacimiento)) : 'NO REG.' }}
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <div class="field-group">
                            <span class="label">COLOR / SEÑAS</span>
                            <span class="value value-sm">{{ \Illuminate\Support\Str::limit($mascota->color ?? '---', 22) }}</span>
                        </div>

                        <div class="owner-box">
                            <span class="label">PROPIETARIO RESPONSABLE</span>
                            <div class="value">
                                {{ strtoupper(optional($mascota->dueno)->nombres ?? 'SIN') }}
                                {{ strtoupper(optional($mascota->dueno)->apellidos ?? 'REGISTRO') }}
                            </div>
                        </div>

                    </td>
                </tr>
            </table>
        </div>

        <div class="footer-stripe"></div>

    </div>

</body>
</html>
