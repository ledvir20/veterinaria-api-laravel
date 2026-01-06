<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carnet Veterinario MPH</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
            /* Margen para que no se pegue al borde de la hoja A4 al imprimir */
            background-color: #f4f4f4;
        }

        /* Contenedor principal tamaño tarjeta de crédito (CR80) */
        .carnet-container {
            width: 85.6mm;
            height: 53.98mm;
            background-color: #fff;
            border-radius: 8px;
            /* Bordes redondeados del carnet */
            overflow: hidden;
            /* Para que el header corte bien las esquinas */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        /* --- COLORES INSTITUCIONALES --- */
        :root {
            --mph-red: #7e1616;
            /* Rojo vino institucional */
            --mph-red-light: #a32a2a;
            /* Un tono ligeramente más claro para el resalte */
            --text-dark: #333;
            --text-label: #555;
        }

        /* --- HEADER --- */
        .header-table {
            width: 100%;
            background-color: var(--mph-red);
            color: white;
            padding: 4px 8px;
            border-bottom: 2px solid #5a0f0f;
        }

        .logo-cell {
            width: 40px;
            vertical-align: middle;
        }

        .header-text-cell {
            vertical-align: middle;
            text-align: left;
            padding-left: 5px;
        }

        .header-title {
            font-size: 9px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .header-subtitle {
            font-size: 6px;
            margin: 1px 0 0 0;
            opacity: 0.9;
        }

        /* --- CUERPO PRINCIPAL (LAYOUT DE 2 COLUMNAS) --- */
        .main-content-table {
            width: 100%;
            height: 75%;
            /* Ocupar el espacio restante */
            border-collapse: collapse;
        }

        .left-column {
            width: 32%;
            vertical-align: top;
            padding: 8px 4px 8px 8px;
            text-align: center;
            border-right: 1px dotted #ccc;
        }

        .right-column {
            width: 68%;
            vertical-align: top;
            padding: 8px 8px 8px 6px;
        }

        /* --- ESTILOS COLUMNA IZQUIERDA (FOTO Y DNI) --- */
        .photo-container {
            width: 65px;
            height: 75px;
            background-color: #e0e0e0;
            border: 2px solid var(--mph-red);
            border-radius: 6px;
            margin: 0 auto 5px auto;
            overflow: hidden;
            position: relative;
        }

        /* Usar esto para centrar el texto si no hay foto real */
        .photo-placeholder-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 8px;
            color: #999;
            font-weight: bold;
        }

        .dni-label {
            font-size: 6px;
            font-weight: bold;
            color: var(--mph-red);
            margin-bottom: 1px;
        }

        .dni-value {
            font-size: 10px;
            font-weight: bold;
            color: #000;
        }

        /* --- ESTILOS COLUMNA DERECHA (DATOS) --- */
        .data-field {
            margin-bottom: 4px;
        }

        .field-label {
            font-size: 6px;
            font-weight: bold;
            color: var(--text-label);
            text-transform: uppercase;
            display: block;
        }

        .field-value {
            font-size: 9px;
            color: var(--text-dark);
            font-weight: bold;
        }

        /* --- CAMPO RESALTADO (Estilo "CARGO" de la imagen) --- */
        .highlight-box {
            background-color: var(--mph-red-light);
            color: white;
            padding: 4px 6px;
            border-radius: 4px;
            margin-top: 6px;
            display: inline-block;
            /* Para que se ajuste al contenido o darle width 100% */
            width: 95%;
        }

        .highlight-box .field-label {
            color: #ffcccc;
            /* Un rosa pálido para la etiqueta sobre rojo */
        }

        .highlight-box .field-value {
            color: white;
            font-size: 10px;
            margin-top: 2px;
        }

        /* --- FOOTER --- */
        .footer-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background-color: var(--mph-red);
        }
    </style>
</head>

<body>

    <div class="carnet-container">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ public_path('images/logo_mph.png') }}" width="35" height="auto" alt="Escudo MPH">
                </td>
                <td class="header-text-cell">
                    <h1 class="header-title">MUNICIPALIDAD PROVINCIAL DE HUAMANGA</h1>
                    {{-- <p class="header-subtitle">GERENCIA DE SERVICIOS PÚBLICOS</p>
                    <p class="header-subtitle" style="font-weight: bold;">REGISTRO VETERINARIO MUNICIPAL</p> --}}
                </td>
            </tr>
        </table>

        <table class="main-content-table">
            <tr>
                <td class="left-column">
                    <div class="photo-container">
                        <div class="photo-placeholder-text">FOTO MASCOTA</div>
                    </div>

                    <div class="dni-label">N° REGISTRO (DNI)</div>
                    <div class="dni-value">{{ $mascota->dni_mascota }}</div>

                    <div style="margin-top:5px; text-align: center;">
                        <img src="data:image/svg+xml;base64, {{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(150)->margin(0)->generate($mascota->dni_mascota)) }}"
                            width="45" height="45">
                    </div>


                </td>

                <td class="right-column">
                    <div class="data-field">
                        <span class="field-label">NOMBRE DE LA MASCOTA</span>
                        <span class="field-value" style="font-size: 11px;">{{ strtoupper($mascota->nombre) }}</span>
                    </div>

                    <table width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td width="60%">
                                <div class="data-field">
                                    <span class="field-label">ESPECIE / RAZA</span>
                                    <span class="field-value">{{ $mascota->especie }} /
                                        {{ \Illuminate\Support\Str::limit($mascota->raza ?? 'Mestizo', 15) }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="data-field">
                                    <span class="field-label">SEXO / NACIMIENTO</span>
                                    <span class="field-value">{{ $mascota->sexo }} /
                                        {{ $mascota->fecha_nacimiento ? date('d/m/Y', strtotime($mascota->fecha_nacimiento)) : '---' }}</span>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="highlight-box">
                        <span class="field-label">PROPIETARIO RESPONSABLE</span>
                        <div class="field-value">
                            {{ strtoupper($mascota->dueno->nombres) }}
                            <br>
                            {{ strtoupper($mascota->dueno->apellidos) }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer-bar"></div>
    </div>

</body>

</html>
