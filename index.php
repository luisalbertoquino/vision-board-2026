<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vision Board 2026 | Luis Alberto Quino</title>
    <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #4a4a4a 100%);
            min-height: 100vh;
            padding: 20px;
            overflow-x: hidden;
            font-size: 16px;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            animation: fadeInDown 1s ease;
        }

        header h1 {
            font-size: 3em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .motto {
            font-size: 1.3em;
            font-style: italic;
            background: rgba(255,255,255,0.2);
            padding: 15px 30px;
            border-radius: 50px;
            display: inline-block;
            backdrop-filter: blur(10px);
            margin-top: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        /* Centrar la última tarjeta cuando hay número impar */
        .card-container:last-child:nth-child(odd) {
            grid-column: 1 / -1;
            max-width: 400px;
            margin: 0 auto;
        }

        .card-container {
            perspective: 1000px;
            height: 500px;
        }

        .card {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            cursor: pointer;
        }

        .card-container:hover .card {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .card-front {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            padding: 0;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            position: absolute;
            top: 0;
            left: 0;
        }

        .card-image-container {
            position: relative;
            width: 100%;
            height: 50%;
            overflow: hidden;
        }

        .card-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .card-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-header {
            flex: 1;
        }

        .card-back {
            background: white;
            transform: rotateY(180deg);
            overflow-y: auto;
            z-index: 10;
        }

        .card-icon {
            font-size: 2.5em;
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 2;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            padding: 10px;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .card-subtitle {
            font-size: 1em;
            opacity: 0.95;
        }

        .goal-item {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .goal-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .goal-text {
            flex: 1;
            font-size: 1em;
            color: #333;
            font-weight: 500;
        }

        .goal-progress {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            margin-left: 32px;
        }

        .progress-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid #667eea;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            font-size: 0.7em;
        }

        .progress-dot.completed {
            background: #667eea;
            color: white;
        }

        .progress-dot:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .frequency-label {
            font-size: 0.85em;
            color: #666;
            font-style: italic;
            margin-left: 32px;
            margin-top: 4px;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 15px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }

        .card-buttons-container {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .importance-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s;
            font-weight: 500;
            flex: 1;
        }

        .importance-btn:hover {
            background: #764ba2;
            transform: scale(1.05);
        }

        /* Colores diferentes para cada categoría - Más oscuros y vivos */
        .card-growth .card-front {
            background: linear-gradient(135deg, #1e3a8a 0%, #0891b2 100%);
        }

        .card-work .card-front {
            background: linear-gradient(135deg, #065f46 0%, #059669 100%);
        }

        .card-health .card-front {
            background: linear-gradient(135deg, #be123c 0%, #fb923c 100%);
        }

        .card-life .card-front {
            background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
        }

        .card-finance .card-front {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .card-mobility .card-front {
            background: linear-gradient(135deg, #be185d 0%, #ec4899 100%);
        }

        /* Modal para importancia */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.85);
            animation: fadeIn 0.3s;
            overflow-y: auto;
        }

        .modal-content {
            position: relative;
            margin: 80px auto;
            max-width: 700px;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }

        .modal-icon {
            font-size: 3em;
        }

        .modal-title {
            font-size: 2em;
            color: #667eea;
            font-weight: bold;
        }

        .importance-content {
            font-size: 1.1em;
            line-height: 1.8;
            color: #333;
        }

        .importance-content h3 {
            color: #667eea;
            margin-top: 25px;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .importance-content ul {
            margin-left: 25px;
            margin-bottom: 20px;
        }

        .importance-content li {
            margin-bottom: 12px;
            font-size: 1.05em;
        }

        .importance-content strong {
            color: #764ba2;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #667eea;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1001;
            transition: all 0.3s;
        }

        .close-modal:hover {
            color: #764ba2;
            transform: scale(1.1);
        }

        .stats-summary {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-top: 30px;
        }

        .stats-summary h2 {
            font-size: 1.8em;
        }

        .stats-summary p {
            font-size: 1.1em;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-item {
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
        }

        .stat-label {
            font-size: 1em;
            opacity: 0.9;
            margin-top: 5px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Botón de evidencias */
        .evidence-btn {
            background: #000;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s;
            font-weight: 500;
            flex: 1;
        }

        .evidence-btn:hover {
            background: #333;
            transform: scale(1.05);
        }

        /* Botón de cambiar portada */
        .change-cover-btn {
            background: #f093fb;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s;
            font-weight: 500;
            width: 100%;
            margin-top: 10px;
        }

        .change-cover-btn:hover {
            background: #f5576c;
            transform: scale(1.05);
        }

        .cover-upload-input {
            display: none;
        }

        /* Modal de evidencias */
        .evidence-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            animation: fadeIn 0.3s;
        }

        .evidence-modal-content {
            position: relative;
            margin: 50px auto;
            max-width: 900px;
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-height: 85vh;
            overflow-y: auto;
        }

        .evidence-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }

        .evidence-title {
            font-size: 1.8em;
            color: #667eea;
            font-weight: bold;
        }

        .upload-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 2px dashed #667eea;
        }

        .upload-input {
            display: none;
        }

        .upload-label {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .upload-label:hover {
            background: #764ba2;
            transform: scale(1.05);
        }

        /* Slider de evidencias */
        .evidence-slider {
            position: relative;
            margin-top: 20px;
        }

        .slider-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
        }

        .slider-track {
            display: flex;
            transition: transform 0.3s ease;
        }

        .slider-item {
            min-width: 100%;
            position: relative;
        }

        .slider-image {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            background: #000;
            border-radius: 10px;
        }

        .slider-caption {
            padding: 15px;
            background: #f8f9fa;
            text-align: center;
            font-size: 1.1em;
            color: #333;
            border-radius: 0 0 10px 10px;
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 15px 20px;
            cursor: pointer;
            font-size: 1.5em;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .slider-nav:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .slider-nav.prev {
            left: 10px;
        }

        .slider-nav.next {
            right: 10px;
        }

        .slider-dots {
            text-align: center;
            margin-top: 15px;
        }

        .slider-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
            margin: 0 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .slider-dot.active {
            background: #667eea;
            transform: scale(1.3);
        }

        .no-evidence {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 1.1em;
        }

        .delete-evidence-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(220, 38, 38, 0.9);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: all 0.3s;
        }

        .delete-evidence-btn:hover {
            background: rgba(185, 28, 28, 1);
        }


        @media (max-width: 768px) {
            header h1 {
                font-size: 2em;
            }
            .motto {
                font-size: 1em;
            }
            .grid {
                grid-template-columns: 1fr;
            }
            .evidence-modal-content {
                margin: 20px;
                padding: 20px;
            }
            .slider-image {
                max-height: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>✨ Vision Board 2026 ✨</h1>
            <div class="motto">
                "Disciplina diaria hoy, tranquilidad y libertad mañana"
            </div>
        </header>

        <div class="grid">
            <!-- Card 1: Crecimiento Profesional -->
            <div class="card-container">
                <div class="card card-growth">
                    <div class="card-front">
                        <div class="card-image-container">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=400&fit=crop"
                                 alt="Crecimiento Profesional"
                                 class="card-image"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22400%22%3E%3Crect fill=%22%234facfe%22 width=%22800%22 height=%22400%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22%3E🌱 Crecimiento%3C/text%3E%3C/svg%3E'">
                            <div class="card-image-overlay"></div>
                            <div class="card-icon">🌱</div>
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <div class="card-title">Crecimiento Profesional</div>
                                <div class="card-subtitle">Aprender, practicar y mostrar</div>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="progress-growth" style="width: 0%"></div>
                                </div>
                                <p style="margin-top: 10px; font-size: 1em;">Toca para ver objetivos</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-back">
                        <h3 style="margin-bottom: 20px; color: #667eea; font-size: 1.3em;">Objetivos de Crecimiento</h3>

                        <!-- Cursos mensuales -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">📚 Cursos completados - 2/mes</span>
                            </div>
                            <div class="frequency-label">Desarrollo, diseño, tecnología (24 cursos al año)</div>
                            <div class="goal-progress" id="courses-progress"></div>
                        </div>

                        <!-- Libros mensuales -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">📖 Libros leídos - 2/mes</span>
                            </div>
                            <div class="frequency-label">1 entretenimiento + 1 educativo (24 libros al año)</div>
                            <div class="goal-progress" id="books-progress"></div>
                        </div>

                        <!-- Inglés - Estudio 3x semana -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🌍 Estudio inglés - 3 días/semana</span>
                            </div>
                            <div class="frequency-label">1 hora por sesión + repaso fin de semana (156 sesiones)</div>
                            <div class="goal-progress" id="english-study"></div>
                        </div>

                        <!-- Tecnologías -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🚀 Nuevas tecnologías con proyecto funcional</span>
                            </div>
                            <div class="frequency-label">Meta: 2 por mes (24 al año)</div>
                            <div class="goal-progress" id="tech-progress"></div>
                        </div>

                        <!-- Dibujos -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🎨 Dibujos semanales en tableta digital</span>
                            </div>
                            <div class="frequency-label">Meta: 1 por semana (52 al año)</div>
                            <div class="goal-progress" id="drawing-progress"></div>
                        </div>

                        <!-- Portafolio -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🧩 Portafolio actualizado constantemente</span>
                            </div>
                            <div class="frequency-label">Actualización mensual (12 veces al año)</div>
                            <div class="goal-progress" id="portfolio-progress"></div>
                        </div>

                        <div class="card-buttons-container">
                            <button class="importance-btn" onclick="showImportance('growth')">💡 ¿Por qué es importante?</button>
                            <button class="evidence-btn" onclick="openEvidenceModal('growth')">🏆 Ver Logros</button>
                        </div>
                        <input type="file" id="cover-upload-growth" class="cover-upload-input" accept="image/*" onchange="uploadCover('growth', this)">
                        <button class="change-cover-btn" onclick="document.getElementById('cover-upload-growth').click()">📷 Cambiar Portada</button>
                    </div>
                </div>
            </div>

            <!-- Card 2: Trabajo & Propósito -->
            <div class="card-container">
                <div class="card card-work">
                    <div class="card-front">
                        <div class="card-image-container">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop"
                                 alt="Trabajo Remoto"
                                 class="card-image"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22400%22%3E%3Crect fill=%22%2343e97b%22 width=%22800%22 height=%22400%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22%3E💼 Trabajo%3C/text%3E%3C/svg%3E'">
                            <div class="card-image-overlay"></div>
                            <div class="card-icon">💼</div>
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <div class="card-title">Trabajo & Propósito</div>
                                <div class="card-subtitle">Tiempo, libertad y bienestar</div>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="progress-work" style="width: 0%"></div>
                                </div>
                                <p style="margin-top: 10px; font-size: 1em;">Toca para ver objetivos</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-back">
                        <h3 style="margin-bottom: 20px; color: #43e97b; font-size: 1.3em;">Objetivos Laborales</h3>

                        <!-- Aplicaciones semanales -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">📝 Aplicaciones a empleos - 10/semana</span>
                            </div>
                            <div class="frequency-label">Búsqueda activa constante (520 aplicaciones al año)</div>
                            <div class="goal-progress" id="job-applications"></div>
                        </div>

                        <!-- Networking -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🤝 Networking profesional - 2/semana</span>
                            </div>
                            <div class="frequency-label">LinkedIn, eventos, contactos (104 conexiones al año)</div>
                            <div class="goal-progress" id="networking"></div>
                        </div>

                        <!-- Entrevistas -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🎯 Entrevistas completadas - Mensual</span>
                            </div>
                            <div class="frequency-label">Seguimiento de entrevistas (12 al año)</div>
                            <div class="goal-progress" id="interviews"></div>
                        </div>

                        <!-- Lectura sobre influencia -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">📚 Libros: Influencia y comunicación</span>
                            </div>
                            <div class="frequency-label">"Cómo influir en otros" y similares (6 libros)</div>
                            <div class="goal-progress" id="influence-books"></div>
                        </div>

                        <!-- Objetivo final -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">💼 Conseguir trabajo remoto ideal</span>
                            </div>
                            <div class="goal-progress" id="remote-job"></div>
                        </div>
                        <div class="card-buttons-container">
                            <button class="importance-btn" onclick="showImportance('work')">💡 ¿Por qué es importante?</button>
                            <button class="evidence-btn" onclick="openEvidenceModal('work')">🏆 Ver Logros</button>
                        </div>
                        <input type="file" id="cover-upload-work" class="cover-upload-input" accept="image/*" onchange="uploadCover('work', this)">
                        <button class="change-cover-btn" onclick="document.getElementById('cover-upload-work').click()">📷 Cambiar Portada</button>
                    </div>
                </div>
            </div>

            <!-- Card 3: Salud & Bienestar -->
            <div class="card-container">
                <div class="card card-health">
                    <div class="card-front">
                        <div class="card-image-container">
                            <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800&h=400&fit=crop"
                                 alt="Salud y Bienestar"
                                 class="card-image"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22400%22%3E%3Crect fill=%22%23fa709a%22 width=%22800%22 height=%22400%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22%3E🏃 Salud%3C/text%3E%3C/svg%3E'">
                            <div class="card-image-overlay"></div>
                            <div class="card-icon">🏃‍♂️</div>
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <div class="card-title">Salud & Bienestar</div>
                                <div class="card-subtitle">Constancia, no perfección</div>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="progress-health" style="width: 0%"></div>
                                </div>
                                <p style="margin-top: 10px; font-size: 1em;">Toca para ver objetivos</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-back">
                        <h3 style="margin-bottom: 20px; color: #fa709a; font-size: 1.3em;">Objetivos de Salud</h3>
                        
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🏃 Trote de 10 km (2 vueltas Único-USCO)</span>
                            </div>
                            <div class="frequency-label">Meta: 3 veces por semana (156 al año)</div>
                            <div class="goal-progress" id="running-progress"></div>
                        </div>

                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🦷 Citas de ortodoncia</span>
                            </div>
                            <div class="frequency-label">Mensual desde enero (12 al año)</div>
                            <div class="goal-progress" id="orthodontics-progress"></div>
                        </div>

                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🍹 Días sin bebidas azucaradas</span>
                            </div>
                            <div class="frequency-label">Meta: Reducción progresiva</div>
                            <div class="goal-progress" id="sugar-progress"></div>
                        </div>

                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">👓 Compra de lentes</span>
                            </div>
                            <div class="goal-progress" id="glasses"></div>
                        </div>

                        <!-- Habilidades Sociales -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">😊 Ser más amigable - Diario</span>
                            </div>
                            <div class="frequency-label">Saludar, sonreír, iniciar conversaciones (365 días)</div>
                            <div class="goal-progress" id="friendly-interactions"></div>
                        </div>

                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">😄 Ser más divertido - Diario</span>
                            </div>
                            <div class="frequency-label">Contar chistes, hacer reír a otros (365 días)</div>
                            <div class="goal-progress" id="humor-moments"></div>
                        </div>

                        <div class="card-buttons-container">
                            <button class="importance-btn" onclick="showImportance('health')">💡 ¿Por qué es importante?</button>
                            <button class="evidence-btn" onclick="openEvidenceModal('health')">🏆 Ver Logros</button>
                        </div>
                        <input type="file" id="cover-upload-health" class="cover-upload-input" accept="image/*" onchange="uploadCover('health', this)">
                        <button class="change-cover-btn" onclick="document.getElementById('cover-upload-health').click()">📷 Cambiar Portada</button>
                    </div>
                </div>
            </div>

            <!-- Card 4: Vida Diaria -->
            <div class="card-container">
                <div class="card card-life">
                    <div class="card-front">
                        <div class="card-image-container">
                            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=800&h=400&fit=crop"
                                 alt="Vida Diaria"
                                 class="card-image"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22400%22%3E%3Crect fill=%22%2330cfd0%22 width=%22800%22 height=%22400%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22%3E🍽️ Vida%3C/text%3E%3C/svg%3E'">
                            <div class="card-image-overlay"></div>
                            <div class="card-icon">🍽️</div>
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <div class="card-title">Vida Diaria</div>
                                <div class="card-subtitle">Disfrutar el proceso</div>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="progress-life" style="width: 0%"></div>
                                </div>
                                <p style="margin-top: 10px; font-size: 1em;">Toca para ver objetivos</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-back">
                        <h3 style="margin-bottom: 20px; color: #30cfd0; font-size: 1.3em;">Objetivos Diarios</h3>
                        
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">👨‍🍳 Almuerzos diferentes preparados</span>
                            </div>
                            <div class="frequency-label">Meta: 1 por semana (52 al año)</div>
                            <div class="goal-progress" id="cooking-progress"></div>
                        </div>

                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🧘 Rutinas de calma establecidas</span>
                            </div>
                            <div class="goal-progress" id="routines"></div>
                        </div>

                        <div class="card-buttons-container">
                            <button class="importance-btn" onclick="showImportance('life')">💡 ¿Por qué es importante?</button>
                            <button class="evidence-btn" onclick="openEvidenceModal('life')">🏆 Ver Logros</button>
                        </div>
                        <input type="file" id="cover-upload-life" class="cover-upload-input" accept="image/*" onchange="uploadCover('life', this)">
                        <button class="change-cover-btn" onclick="document.getElementById('cover-upload-life').click()">📷 Cambiar Portada</button>
                    </div>
                </div>
            </div>

            <!-- Card 5: Finanzas -->
            <div class="card-container">
                <div class="card card-finance">
                    <div class="card-front">
                        <div class="card-image-container">
                            <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=800&h=400&fit=crop"
                                 alt="Finanzas"
                                 class="card-image"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22400%22%3E%3Crect fill=%22%23a8edea%22 width=%22800%22 height=%22400%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22%3E💰 Finanzas%3C/text%3E%3C/svg%3E'">
                            <div class="card-image-overlay"></div>
                            <div class="card-icon">💰</div>
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <div class="card-title">Finanzas</div>
                                <div class="card-subtitle">Tranquilidad y control</div>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="progress-finance" style="width: 0%"></div>
                                </div>
                                <p style="margin-top: 10px; font-size: 1em;">Toca para ver objetivos</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-back">
                        <h3 style="margin-bottom: 20px; color: #a8edea; font-size: 1.3em;">Objetivos Financieros 2026</h3>

                        <!-- Presupuesto Enero 2026 - Ahorro como gasto fijo -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">💰 Ahorro mensual (gasto fijo) - 12 meses</span>
                            </div>
                            <div class="frequency-label">Ahorrar PRIMERO antes que gastar (12 meses)</div>
                            <div class="goal-progress" id="savings-progress"></div>
                        </div>

                        <!-- Bolsillo Comfamiliar -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🏦 Bolsillo Comfamiliar: $800k → $2.8M</span>
                            </div>
                            <div class="frequency-label">Ahorrar $800k mensuales como bolsillo (meta $2.8M)</div>
                            <div class="goal-progress" id="comfamiliar-pocket"></div>
                        </div>

                        <!-- Pase moto: Prima + 200k mensuales -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🏍️ Pase moto: Prima mitad de mes + $200k/mes</span>
                            </div>
                            <div class="frequency-label">Pagos mensuales de $200k (12 meses)</div>
                            <div class="goal-progress" id="motorcycle-license-fund"></div>
                        </div>

                        <!-- Bolsillo familiar -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">👨‍👩‍👧 Bolsillo familiar: $20k/mes para 2027</span>
                            </div>
                            <div class="frequency-label">Ahorro anual = $240k para salida familiar 2027</div>
                            <div class="goal-progress" id="family-fund"></div>
                        </div>

                        <!-- Bolsillo ortodoncia -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🦷 Bolsillo ortodoncia: $150-200k/mes</span>
                            </div>
                            <div class="frequency-label">18 meses = $2.7M-3.6M (brackets metálicos ~$3M)</div>
                            <div class="goal-progress" id="orthodontics-pocket"></div>
                        </div>

                        <!-- Preparación previa inglés -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🌍 Preparación inglés (ene-may) + Curso (jun-dic)</span>
                            </div>
                            <div class="frequency-label">5 meses preparación + 6 meses curso formal</div>
                            <div class="goal-progress" id="english-preparation"></div>
                        </div>

                        <!-- Bolsillo curso inglés -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">💰 Bolsillo curso inglés: $150-200k/mes</span>
                            </div>
                            <div class="frequency-label">Ahorro ene-may = $750k-1M para curso jun-dic</div>
                            <div class="goal-progress" id="english-pocket"></div>
                        </div>

                        <!-- Pagos ICETEX -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">📉 Pagos ICETEX - Mensual</span>
                            </div>
                            <div class="frequency-label">Reducción progresiva (12 pagos)</div>
                            <div class="goal-progress" id="icetex-progress"></div>
                        </div>

                        <!-- Inversiones seguras -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">📈 Investigar inversiones seguras</span>
                            </div>
                            <div class="frequency-label">CDTs, fondos, alternativas de bajo riesgo</div>
                            <div class="goal-progress" id="investment-research"></div>
                        </div>

                        <!-- Ingresos extra -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">💼 Fuentes de ingreso extra</span>
                            </div>
                            <div class="frequency-label">Freelance, proyectos, consultoría</div>
                            <div class="goal-progress" id="extra-income"></div>
                        </div>

                        <div class="card-buttons-container">
                            <button class="importance-btn" onclick="showImportance('finance')">💡 ¿Por qué es importante?</button>
                            <button class="evidence-btn" onclick="openEvidenceModal('finance')">🏆 Ver Logros</button>
                        </div>
                        <input type="file" id="cover-upload-finance" class="cover-upload-input" accept="image/*" onchange="uploadCover('finance', this)">
                        <button class="change-cover-btn" onclick="document.getElementById('cover-upload-finance').click()">📷 Cambiar Portada</button>
                    </div>
                </div>
            </div>

            <!-- Card 6: Movilidad -->
            <div class="card-container">
                <div class="card card-mobility">
                    <div class="card-front">
                        <div class="card-image-container">
                            <img src="https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=800&h=400&fit=crop"
                                 alt="Movilidad"
                                 class="card-image"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22400%22%3E%3Crect fill=%22%23ff9a9e%22 width=%22800%22 height=%22400%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22%3E🛵 Movilidad%3C/text%3E%3C/svg%3E'">
                            <div class="card-image-overlay"></div>
                            <div class="card-icon">🛵</div>
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <div class="card-title">Movilidad</div>
                                <div class="card-subtitle">Opciones abiertas</div>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="progress-mobility" style="width: 0%"></div>
                                </div>
                                <p style="margin-top: 10px; font-size: 1em;">Toca para ver objetivos</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-back">
                        <h3 style="margin-bottom: 20px; color: #ff9a9e; font-size: 1.3em;">Objetivos de Movilidad</h3>

                        <!-- Licencias -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🪪 Licencia A2 (Moto) - PRIORIDAD</span>
                            </div>
                            <div class="frequency-label">Categoría A2 para motos hasta 500cc</div>
                            <div class="goal-progress" id="license-moto"></div>
                        </div>

                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🚗 Licencia B1 (Carro) - Opcional</span>
                            </div>
                            <div class="frequency-label">Para viajes largos y clima adverso</div>
                            <div class="goal-progress" id="license-car"></div>
                        </div>

                        <!-- Tipo de moto deseada -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🏍️ Investigar moto: Naked/Sport 250-300cc</span>
                            </div>
                            <div class="frequency-label">Yamaha MT-03, KTM Duke 390, BMW G310R o similar</div>
                            <div class="goal-progress" id="motorcycle-research"></div>
                        </div>

                        <!-- Plan de compra 2027 -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">💰 Plan de compra 2027: Usar bonificación</span>
                            </div>
                            <div class="frequency-label">Ahorro + bonificación anual para compra</div>
                            <div class="goal-progress" id="motorcycle-purchase-plan"></div>
                        </div>

                        <!-- Curso de manejo defensivo -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🛡️ Curso de manejo defensivo</span>
                            </div>
                            <div class="frequency-label">Seguridad en moto, técnicas avanzadas</div>
                            <div class="goal-progress" id="defensive-driving"></div>
                        </div>

                        <div class="card-buttons-container">
                            <button class="importance-btn" onclick="showImportance('mobility')">💡 ¿Por qué es importante?</button>
                            <button class="evidence-btn" onclick="openEvidenceModal('mobility')">🏆 Ver Logros</button>
                        </div>
                        <input type="file" id="cover-upload-mobility" class="cover-upload-input" accept="image/*" onchange="uploadCover('mobility', this)">
                        <button class="change-cover-btn" onclick="document.getElementById('cover-upload-mobility').click()">📷 Cambiar Portada</button>
                    </div>
                </div>
            </div>

            <!-- Card 7: Vida Social & Espiritual -->
            <div class="card-container">
                <div class="card card-social">
                    <div class="card-front">
                        <div class="card-image-container">
                            <img src="https://images.unsplash.com/photo-1511895426328-dc8714191300?w=800&h=400&fit=crop"
                                 alt="Vida Social"
                                 class="card-image"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22400%22%3E%3Crect fill=%22%23ff6b9d%22 width=%22800%22 height=%22400%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22%3E❤️ Vida Social%3C/text%3E%3C/svg%3E'">
                            <div class="card-image-overlay"></div>
                            <div class="card-icon">❤️</div>
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <div class="card-title">Vida Social & Espiritual</div>
                                <div class="card-subtitle">Conexiones y relaciones significativas</div>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="progress-social" style="width: 0%"></div>
                                </div>
                                <p style="margin-top: 10px; font-size: 1em;">Toca para ver objetivos</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-back">
                        <h3 style="color: #667eea; margin-bottom: 15px;">❤️ Vida Social & Espiritual</h3>

                        <!-- Familia -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">👨‍👩‍👧 Conexión familiar - 2 actividades/mes</span>
                            </div>
                            <div class="frequency-label">Compartir tiempo de calidad (24 veces al año)</div>
                            <div class="goal-progress" id="family-connection"></div>
                        </div>

                        <!-- Nuevas Amistades -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🤝 Hacer nuevos amigos - 1 amistad/mes</span>
                            </div>
                            <div class="frequency-label">Conocer personas nuevas (12 amigos nuevos al año)</div>
                            <div class="goal-progress" id="new-friends"></div>
                        </div>

                        <!-- Eventos Sociales -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🎉 Asistir a eventos sociales - 2/mes</span>
                            </div>
                            <div class="frequency-label">Fiestas, reuniones, actividades grupales (24 eventos)</div>
                            <div class="goal-progress" id="social-events"></div>
                        </div>

                        <!-- Vida de Pareja -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">💑 Citas y encuentros - 2 citas/mes</span>
                            </div>
                            <div class="frequency-label">Conocer personas para relación (24 citas al año)</div>
                            <div class="goal-progress" id="dating"></div>
                        </div>

                        <!-- Ejercicios Kegel -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">🧘 Ejercicios Kegel - Lunes a Viernes (noche)</span>
                            </div>
                            <div class="frequency-label">Rutina nocturna para salud pélvica (260 sesiones al año)</div>
                            <div class="goal-progress" id="kegel-exercises"></div>
                        </div>

                        <!-- Gratitud -->
                        <div class="goal-item">
                            <div class="goal-header">
                                <span class="goal-text">📝 Diario de gratitud - Diario</span>
                            </div>
                            <div class="frequency-label">Escribir 3 agradecimientos diarios (365 días)</div>
                            <div class="goal-progress" id="gratitude"></div>
                        </div>

                        <div class="card-buttons-container">
                            <button class="importance-btn" onclick="showImportance('social')">💡 ¿Por qué es importante?</button>
                            <button class="evidence-btn" onclick="openEvidenceModal('social')">🏆 Ver Logros</button>
                        </div>
                        <input type="file" id="cover-upload-social" class="cover-upload-input" accept="image/*" onchange="uploadCover('social', this)">
                        <button class="change-cover-btn" onclick="document.getElementById('cover-upload-social').click()">📷 Cambiar Portada</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Resumen -->
        <div class="stats-summary">
            <h2 style="color: #667eea; margin-bottom: 10px;">📊 Mi Progreso General</h2>
            <p style="color: #666; margin-bottom: 20px;">Sigue avanzando hacia tus objetivos</p>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number" id="total-goals">0</div>
                    <div class="stat-label">Objetivos Totales</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="completed-goals">0</div>
                    <div class="stat-label">Completados</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="completion-percent">0%</div>
                    <div class="stat-label">Progreso Total</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="days-active">1</div>
                    <div class="stat-label">Días Activo</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para importancia -->
    <div id="importanceModal" class="modal">
        <span class="close-modal" onclick="closeImportance()">&times;</span>
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon" id="modal-icon">🌱</div>
                <div class="modal-title" id="modal-title">Importancia</div>
            </div>
            <div class="importance-content" id="importance-text">
                <!-- El contenido se cargará dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Modal de evidencias -->
    <div id="evidenceModal" class="evidence-modal">
        <div class="evidence-modal-content">
            <span class="close-modal" onclick="closeEvidenceModal()">&times;</span>
            <div class="evidence-header">
                <div class="evidence-title" id="evidence-category-title">Mis Logros</div>
            </div>

            <div class="upload-section">
                <h3 style="margin-bottom: 15px; color: #667eea;">Subir Nueva Evidencia</h3>
                <input type="file" id="evidenceUpload" class="upload-input" accept="image/*" onchange="uploadEvidence(event)">
                <label for="evidenceUpload" class="upload-label">📸 Seleccionar Imagen</label>
                <p style="margin-top: 10px; color: #666; font-size: 0.95em;">Sube una foto de tu logro completado</p>
            </div>

            <div class="evidence-slider" id="evidenceSlider">
                <!-- El slider se generará dinámicamente -->
            </div>
        </div>
    </div>

    <script>
        // Configuración de objetivos con su frecuencia
        const goalsConfig = {
            'courses-progress': { max: 24, category: 'growth' }, // 2 cursos/mes
            'books-progress': { max: 24, category: 'growth' }, // 2 libros/mes
            'english-study': { max: 156, category: 'growth' }, // 3 días/semana
            'tech-progress': { max: 24, category: 'growth' },
            'drawing-progress': { max: 52, category: 'growth' },
            'portfolio-progress': { max: 12, category: 'growth' },
            
            'job-applications': { max: 52, category: 'work' }, // 10/semana (mostramos semanas)
            'networking': { max: 104, category: 'work' }, // 2/semana
            'interviews': { max: 12, category: 'work' }, // Mensual
            'influence-books': { max: 6, category: 'work' }, // 6 libros sobre influencia
            'remote-job': { max: 1, category: 'work' }, // Objetivo final
            
            'running-progress': { max: 156, category: 'health' }, // 3x semana
            'orthodontics-progress': { max: 12, category: 'health' },
            'sugar-progress': { max: 52, category: 'health' }, // Semanas sin azúcar
            'glasses': { max: 1, category: 'health' },
            'friendly-interactions': { max: 365, category: 'health' }, // Diario
            'humor-moments': { max: 365, category: 'health' }, // Diario
            
            'cooking-progress': { max: 52, category: 'life' },
            'routines': { max: 1, category: 'life' },
            
            'savings-progress': { max: 12, category: 'finance' }, // 12 meses ahorrando
            'comfamiliar-pocket': { max: 4, category: 'finance' }, // 800k x 4 meses = 3.2M (>2.8M meta)
            'icetex-progress': { max: 12, category: 'finance' }, // 12 pagos mensuales
            'orthodontics-pocket': { max: 18, category: 'finance' }, // 150-200k x 18 meses
            'english-preparation': { max: 1, category: 'growth' }, // Ene-May preparación
            'english-pocket': { max: 5, category: 'finance' }, // 150-200k x 5 meses (ene-may)
            'investment-research': { max: 1, category: 'finance' }, // Objetivo único
            'extra-income': { max: 1, category: 'finance' }, // Objetivo único
            'motorcycle-license-fund': { max: 12, category: 'finance' }, // Prima + 200k/mes
            'family-fund': { max: 12, category: 'finance' }, // 20k/mes x 12 meses = 240k para 2027

            'license-moto': { max: 1, category: 'mobility' }, // Licencia A2
            'license-car': { max: 1, category: 'mobility' }, // Licencia B1
            'motorcycle-research': { max: 1, category: 'mobility' }, // Investigar motos
            'motorcycle-purchase-plan': { max: 1, category: 'mobility' }, // Plan 2027
            'defensive-driving': { max: 1, category: 'mobility' }, // Curso seguridad

            'family-connection': { max: 24, category: 'social' }, // 2 actividades/mes
            'new-friends': { max: 12, category: 'social' }, // 1 amistad/mes
            'social-events': { max: 24, category: 'social' }, // 2 eventos/mes
            'dating': { max: 24, category: 'social' }, // 2 citas/mes
            'kegel-exercises': { max: 260, category: 'social' }, // Lunes-viernes noche
            'gratitude': { max: 365, category: 'social' } // Diario
        };

        // Contenido de importancia para cada categoría
        const importanceContent = {
            'growth': {
                icon: '🌱',
                title: 'Crecimiento Profesional',
                content: `
                    <h3>¿Por qué invertir en tu crecimiento profesional?</h3>
                    <p>El desarrollo continuo de habilidades técnicas no es solo una ventaja competitiva, es una <strong>necesidad en el mundo tecnológico actual</strong>. Cada nueva tecnología que dominas multiplica tus oportunidades laborales y tu valor en el mercado.</p>
                    
                    <h3>Beneficios directos:</h3>
                    <ul>
                        <li><strong>Mayores oportunidades laborales:</strong> Las empresas remotas y tech buscan constantemente profesionales actualizados con portafolios demostrables</li>
                        <li><strong>Mejor remuneración:</strong> Dominar tecnologías modernas puede incrementar tu salario entre 30-50% en 1-2 años</li>
                        <li><strong>Trabajo remoto:</strong> El dominio técnico te abre las puertas al trabajo remoto internacional, con sueldos en dólares o euros</li>
                        <li><strong>Proyectos propios:</strong> Con las habilidades correctas, puedes crear productos digitales que generen ingresos pasivos</li>
                        <li><strong>Inglés técnico:</strong> El 80% de la documentación tech está en inglés. Dominarlo te da acceso a recursos ilimitados y oportunidades globales</li>
                    </ul>

                    <h3>El portafolio es tu carta de presentación:</h3>
                    <p>Un portafolio actualizado con proyectos reales vale más que 10 certificados. Demuestra que no solo sabes teoría, sino que <strong>puedes ejecutar y entregar resultados</strong>.</p>
                `
            },
            'work': {
                icon: '💼',
                title: 'Trabajo & Propósito',
                content: `
                    <h3>¿Por qué buscar un trabajo alineado con tu vida?</h3>
                    <p>Pasamos más de 8 horas diarias trabajando. Si ese tiempo no te aporta <strong>crecimiento, bienestar o propósito</strong>, estás sacrificando tu vida por un salario.</p>
                    
                    <h3>El trabajo remoto cambia tu calidad de vida:</h3>
                    <ul>
                        <li><strong>Tiempo recuperado:</strong> Sin desplazamientos, recuperas 2-3 horas diarias para ti mismo, tu familia o tus proyectos</li>
                        <li><strong>Flexibilidad:</strong> Puedes organizar tu día de forma más eficiente y productiva según tus ritmos naturales</li>
                        <li><strong>Salud mental:</strong> Menos estrés de tráfico, menos presión social de oficina, más autonomía</li>
                        <li><strong>Oportunidades globales:</strong> Acceso a empresas de todo el mundo sin necesidad de migrar</li>
                        <li><strong>Balance real:</strong> Más tiempo para ejercicio, alimentación saludable, hobbies y relaciones importantes</li>
                    </ul>

                    <h3>Trabajo con propósito:</h3>
                    <p>Un trabajo que te permita crecer profesionalmente mientras mantienes tu bienestar no es un lujo, es un <strong>derecho que puedes construir</strong> con las habilidades correctas.</p>
                `
            },
            'health': {
                icon: '🏃‍♂️',
                title: 'Salud & Bienestar',
                content: `
                    <h3>Tu salud es tu verdadero capital</h3>
                    <p>Sin salud, todo lo demás pierde sentido. La inversión en tu cuerpo y bienestar hoy te ahorra <strong>dolor, dinero y tiempo</strong> en el futuro.</p>
                    
                    <h3>Beneficios del ejercicio constante:</h3>
                    <ul>
                        <li><strong>Salud cardiovascular:</strong> Reduce riesgo de enfermedades del corazón en un 35%</li>
                        <li><strong>Energía diaria:</strong> Mejora tu rendimiento mental y físico durante todo el día</li>
                        <li><strong>Salud mental:</strong> Reduce ansiedad, depresión y mejora tu estado de ánimo naturalmente</li>
                        <li><strong>Mejor sueño:</strong> El ejercicio regular mejora la calidad del descanso</li>
                        <li><strong>Longevidad:</strong> Agrega años de vida saludable y activa</li>
                    </ul>

                    <h3>Inversiones médicas preventivas:</h3>
                    <ul>
                        <li><strong>Ortodoncia:</strong> No es solo estética. Mejora digestión, previene dolores de cabeza y problemas de mandíbula. Una inversión que dura toda la vida</li>
                        <li><strong>Lentes correctivos:</strong> Previene dolores de cabeza, mejora productividad y protege tu salud visual a largo plazo</li>
                        <li><strong>Reducción de azúcar:</strong> Previene diabetes, mejora energía, protege tus dientes y reduce inflamación</li>
                    </ul>

                    <p><strong>La constancia importa más que la intensidad.</strong> 3 trotes semanales de 30 minutos valen más que un maratón esporádico.</p>
                `
            },
            'life': {
                icon: '🍽️',
                title: 'Vida Diaria & Autocuidado',
                content: `
                    <h3>Las pequeñas rutinas construyen una gran vida</h3>
                    <p>La felicidad no está en los grandes logros, sino en <strong>disfrutar el proceso diario</strong>. Las rutinas que te cuidan son inversiones en tu bienestar emocional.</p>
                    
                    <h3>Cocinar como autocuidado:</h3>
                    <ul>
                        <li><strong>Salud física:</strong> Control total sobre lo que comes, mejor nutrición</li>
                        <li><strong>Economía:</strong> Ahorras significativamente vs comer fuera</li>
                        <li><strong>Creatividad:</strong> Experimentar con recetas nuevas es terapéutico</li>
                        <li><strong>Mindfulness:</strong> Cocinar te obliga a estar presente y concentrado</li>
                        <li><strong>Orgullo personal:</strong> Cada comida exitosa es un pequeño logro</li>
                    </ul>

                    <h3>Rutinas de calma:</h3>
                    <p>En un mundo acelerado, necesitas <strong>espacios de tranquilidad intencionales</strong>:</p>
                    <ul>
                        <li>Rutina matutina sin pantallas (15 minutos)</li>
                        <li>Momentos de lectura o dibujo sin presión</li>
                        <li>Caminatas sin objetivo, solo para pensar</li>
                        <li>Horarios de desconexión digital</li>
                    </ul>

                    <p>Estas rutinas no son "perder tiempo", son <strong>inversiones en tu salud mental</strong> que te hacen más productivo y feliz el resto del día.</p>
                `
            },
            'finance': {
                icon: '💰',
                title: 'Finanzas & Estabilidad',
                content: `
                    <h3>La tranquilidad financiera es libertad</h3>
                    <p>El dinero no compra la felicidad, pero la <strong>falta de estabilidad financiera genera estrés constante</strong> que afecta tu salud, relaciones y decisiones.</p>
                    
                    <h3>Fondo de emergencia:</h3>
                    <ul>
                        <li><strong>Tranquilidad mental:</strong> Saber que puedes sobrevivir 3-6 meses sin ingresos te da poder de decisión</li>
                        <li><strong>Mejores decisiones laborales:</strong> No aceptas trabajos por desesperación</li>
                        <li><strong>Salud reducida:</strong> El estrés financiero es una de las principales causas de ansiedad</li>
                        <li><strong>Oportunidades:</strong> Puedes invertir en tu educación o proyectos sin miedo</li>
                    </ul>

                    <h3>Eliminar deudas:</h3>
                    <p>Cada peso que pagas de más en intereses es dinero que le quitas a tu futuro. <strong>Priorizar el pago de deudas</strong> libera flujo de caja para invertir en ti mismo:</p>
                    <ul>
                        <li><strong>Comfamiliar:</strong> Terminar este crédito libera presupuesto mensual</li>
                        <li><strong>ICETEX:</strong> Reducción progresiva disminuye la presión financiera y mejora tu score crediticio</li>
                    </ul>

                    <h3>La disciplina financiera es un superpoder:</h3>
                    <p>Ahorrar consistentemente, aunque sean montos pequeños, <strong>construye hábitos que cambian tu vida</strong>. No se trata de ser tacaño, sino de ser intencional con tu dinero.</p>
                `
            },
            'mobility': {
                icon: '🛵',
                title: 'Movilidad & Independencia',
                content: `
                    <h3>La movilidad es independencia</h3>
                    <p>Tener licencia de conducción (especialmente de moto) <strong>multiplica tus opciones</strong> en lo laboral, personal y de emergencias.</p>
                    
                    <h3>Beneficios de la licencia de moto:</h3>
                    <ul>
                        <li><strong>Economía:</strong> Más barato que carro en mantenimiento, combustible y parqueadero</li>
                        <li><strong>Agilidad urbana:</strong> Evitas trancones, llegas más rápido a todos lados</li>
                        <li><strong>Oportunidades laborales:</strong> Muchos trabajos remotos/freelance requieren movilidad propia</li>
                        <li><strong>Flexibilidad:</strong> No dependes de horarios de transporte público</li>
                        <li><strong>Emergencias:</strong> Puedes moverte cuando lo necesites sin depender de nadie</li>
                    </ul>

                    <h3>Licencia de carro (opcional):</h3>
                    <p>Aunque no sea prioritario ahora, tener la licencia de carro te da <strong>opciones futuras</strong>:</p>
                    <ul>
                        <li>Viajes largos más cómodos</li>
                        <li>Transporte de cosas grandes</li>
                        <li>Clima adverso (lluvia fuerte)</li>
                        <li>Opciones laborales que requieren carro</li>
                    </ul>

                    <p><strong>La movilidad es poder:</strong> Poder elegir cuándo moverte, a dónde ir y no depender de nadie ni de nada.</p>
                `
            },
            'social': {
                icon: '❤️',
                title: 'Vida Social & Espiritual',
                content: `
                    <h3>Las relaciones son el verdadero tesoro</h3>
                    <p>El estudio más largo sobre felicidad (Harvard, 80+ años) demostró que <strong>las relaciones significativas son el factor #1 para una vida plena</strong>, incluso más que dinero o éxito profesional.</p>

                    <h3>Conexión familiar:</h3>
                    <ul>
                        <li><strong>Red de apoyo incondicional:</strong> Tu familia estará ahí en los momentos difíciles</li>
                        <li><strong>Salud mental:</strong> Sentirse parte de algo más grande reduce depresión y ansiedad</li>
                        <li><strong>Perspectiva:</strong> La familia te recuerda quién eres y de dónde vienes</li>
                        <li><strong>Legado:</strong> Las memorias compartidas son lo que realmente perdura</li>
                    </ul>

                    <h3>Nuevas amistades y círculo social:</h3>
                    <p>Hacer nuevos amigos <strong>expande tu visión del mundo</strong> y te conecta con nuevas oportunidades:</p>
                    <ul>
                        <li><strong>Diversidad de perspectivas:</strong> Cada persona aporta experiencias únicas</li>
                        <li><strong>Oportunidades:</strong> Tu red social es tu red de oportunidades laborales y personales</li>
                        <li><strong>Crecimiento personal:</strong> Los amigos te desafían a ser mejor versión de ti mismo</li>
                        <li><strong>Felicidad:</strong> Las experiencias compartidas son más memorables que las solitarias</li>
                    </ul>

                    <h3>Vida de pareja:</h3>
                    <p>Encontrar una pareja compatible <strong>multiplica la alegría y divide las penas</strong>:</p>
                    <ul>
                        <li><strong>Compañía:</strong> Alguien con quien compartir los éxitos y superar los fracasos</li>
                        <li><strong>Crecimiento mutuo:</strong> Una buena pareja te impulsa a ser mejor persona</li>
                        <li><strong>Intimidad emocional:</strong> Tener a alguien que realmente te conozca y acepte</li>
                        <li><strong>Proyecto de vida:</strong> Construir algo juntos da propósito y dirección</li>
                    </ul>

                    <h3>Crecimiento espiritual:</h3>
                    <p>La meditación, reflexión y gratitud <strong>te conectan contigo mismo</strong>:</p>
                    <ul>
                        <li><strong>Paz interior:</strong> Reduce ansiedad y estrés significativamente</li>
                        <li><strong>Claridad mental:</strong> Te ayuda a tomar mejores decisiones</li>
                        <li><strong>Resiliencia:</strong> Desarrollas capacidad de enfrentar adversidades</li>
                        <li><strong>Propósito:</strong> Comprendes mejor qué es realmente importante para ti</li>
                    </ul>

                    <p><strong>El éxito sin conexiones humanas es vacío.</strong> Invierte tiempo en relaciones significativas - es la inversión más valiosa que puedes hacer.</p>
                `
            }
        };

        // Sistema de almacenamiento (ahora en base de datos)
        const STORAGE_KEY = 'visionBoardData2026';
        let visionData = {
            goals: {},
            startDate: new Date().toISOString()
        };
        let evidenceData = {
            growth: [],
            work: [],
            health: [],
            life: [],
            finance: [],
            mobility: [],
            social: []
        };
        let currentCategory = '';
        let currentSlideIndex = 0;

        // Inicializar puntos de progreso
        function initializeProgress() {
            Object.keys(goalsConfig).forEach(goalId => {
                const config = goalsConfig[goalId];
                const container = document.getElementById(goalId);
                
                if (container) {
                    container.innerHTML = '';
                    
                    for (let i = 0; i < config.max; i++) {
                        const dot = document.createElement('div');
                        dot.className = 'progress-dot';
                        dot.dataset.goalId = goalId;
                        dot.dataset.index = i;
                        
                        if (visionData.goals[goalId] && visionData.goals[goalId][i]) {
                            dot.classList.add('completed');
                            dot.textContent = '✓';
                        }
                        
                        dot.onclick = function() {
                            toggleProgress(goalId, i);
                        };
                        
                        container.appendChild(dot);
                    }
                }
            });
        }

        // Toggle progreso
        async function toggleProgress(goalId, index) {
            if (!visionData.goals[goalId]) {
                visionData.goals[goalId] = {};
            }

            const wasCompleted = visionData.goals[goalId][index];
            const newState = !visionData.goals[goalId][index];
            visionData.goals[goalId][index] = newState;

            const dot = document.querySelector(`[data-goal-id="${goalId}"][data-index="${index}"]`);
            if (dot) {
                if (newState) {
                    dot.classList.add('completed');
                    dot.textContent = '✓';
                    // Lanzar confeti solo cuando se completa (no cuando se desmarca)
                    if (!wasCompleted) {
                        launchConfetti();
                    }
                } else {
                    dot.classList.remove('completed');
                    dot.textContent = '';
                }
            }

            // Guardar en base de datos
            try {
                console.log('Guardando progreso:', { goalId, index, newState });

                const response = await fetch('api.php?action=toggle_progress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        goal_id: goalId,
                        goal_index: index,
                        is_completed: newState
                    })
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Error HTTP al guardar:', response.status, errorText);
                    return;
                }

                const responseText = await response.text();
                let result;
                try {
                    result = JSON.parse(responseText);
                } catch (e) {
                    console.error('Error al parsear respuesta:', e);
                    console.error('Respuesta:', responseText);
                    return;
                }

                console.log('Resultado del guardado:', result);

                if (!result.success) {
                    console.error('Error al guardar progreso:', result.message);
                    // Revertir cambio visual si falla
                    visionData.goals[goalId][index] = wasCompleted;
                    if (dot) {
                        if (wasCompleted) {
                            dot.classList.add('completed');
                            dot.textContent = '✓';
                        } else {
                            dot.classList.remove('completed');
                            dot.textContent = '';
                        }
                    }
                } else {
                    console.log('Progreso guardado exitosamente');
                }
            } catch (error) {
                console.error('Error al guardar progreso:', error);
            }

            updateProgress(goalsConfig[goalId].category);
            updateStats();
        }

        // Cargar datos guardados
        async function loadData() {
            // Cargar progreso desde la base de datos
            try {
                const response = await fetch('api.php?action=get_all_progress');
                const result = await response.json();
                if (result.success && result.data) {
                    // Transformar datos del API (que vienen como {completed: bool, date: string})
                    // a formato simple (true/false)
                    const transformedData = {};
                    for (const goalId in result.data) {
                        transformedData[goalId] = {};
                        for (const index in result.data[goalId]) {
                            transformedData[goalId][index] = result.data[goalId][index].completed;
                        }
                    }
                    visionData.goals = transformedData;
                    console.log('Datos cargados desde BD:', transformedData);
                }
            } catch (error) {
                console.error('Error al cargar progreso:', error);
            }

            initializeProgress();
            updateAllProgress();
            updateStats();
        }

        // Guardar datos (ya no se usa, todo va a BD)
        // function saveData() {
        //     localStorage.setItem(STORAGE_KEY, JSON.stringify(visionData));
        // }

        // Cargar evidencias desde base de datos
        async function loadEvidences(category) {
            try {
                const response = await fetch(`api.php?action=get_evidences&category=${category}`);

                // Verificar si la respuesta es válida
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Error HTTP:', response.status, errorText);
                    return [];
                }

                const responseText = await response.text();
                console.log('Respuesta del servidor:', responseText.substring(0, 500));

                let result;
                try {
                    result = JSON.parse(responseText);
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    console.error('Respuesta recibida:', responseText);
                    return [];
                }

                if (result.success) {
                    evidenceData[category] = result.data || [];
                    return result.data || [];
                } else {
                    console.error('Error del servidor:', result.message);
                    return [];
                }
            } catch (error) {
                console.error('Error al cargar evidencias:', error);
                return [];
            }
        }

        // Actualizar progreso de una categoría
        function updateProgress(category) {
            let totalPoints = 0;
            let completedPoints = 0;
            
            Object.keys(goalsConfig).forEach(goalId => {
                const config = goalsConfig[goalId];
                if (config.category === category) {
                    totalPoints += config.max;
                    if (visionData.goals[goalId]) {
                        completedPoints += Object.values(visionData.goals[goalId]).filter(v => v).length;
                    }
                }
            });
            
            const percentage = totalPoints > 0 ? (completedPoints / totalPoints) * 100 : 0;
            const progressBar = document.getElementById(`progress-${category}`);
            if (progressBar) {
                progressBar.style.width = percentage + '%';
            }
            
            return { totalPoints, completedPoints, percentage };
        }

        // Actualizar todos los progresos
        function updateAllProgress() {
            const categories = ['growth', 'work', 'health', 'life', 'finance', 'mobility', 'social'];
            categories.forEach(cat => updateProgress(cat));
        }

        // Actualizar estadísticas generales
        function updateStats() {
            let totalPoints = 0;
            let completedPoints = 0;
            
            Object.keys(goalsConfig).forEach(goalId => {
                const config = goalsConfig[goalId];
                totalPoints += config.max;
                if (visionData.goals[goalId]) {
                    completedPoints += Object.values(visionData.goals[goalId]).filter(v => v).length;
                }
            });
            
            const percentage = totalPoints > 0 ? Math.round((completedPoints / totalPoints) * 100) : 0;
            
            document.getElementById('total-goals').textContent = totalPoints;
            document.getElementById('completed-goals').textContent = completedPoints;
            document.getElementById('completion-percent').textContent = percentage + '%';
            
            // Calcular días activos
            if (visionData.startDate) {
                const start = new Date(visionData.startDate);
                const now = new Date();
                const days = Math.floor((now - start) / (1000 * 60 * 60 * 24)) + 1;
                document.getElementById('days-active').textContent = days;
            }
        }

        // Mostrar popup de importancia
        function showImportance(category) {
            const modal = document.getElementById('importanceModal');
            const content = importanceContent[category];
            
            if (content) {
                document.getElementById('modal-icon').textContent = content.icon;
                document.getElementById('modal-title').textContent = content.title;
                document.getElementById('importance-text').innerHTML = content.content;
                modal.style.display = 'block';
            }
        }

        function closeImportance() {
            document.getElementById('importanceModal').style.display = 'none';
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modal = document.getElementById('importanceModal');
            const evidenceModal = document.getElementById('evidenceModal');
            if (event.target == modal) {
                closeImportance();
            }
            if (event.target == evidenceModal) {
                closeEvidenceModal();
            }
        };

        // ========== SISTEMA DE EVIDENCIAS ==========

        // Abrir modal de evidencias
        async function openEvidenceModal(category) {
            currentCategory = category;
            currentSlideIndex = 0;
            const modal = document.getElementById('evidenceModal');
            const categoryNames = {
                growth: 'Crecimiento Profesional',
                work: 'Trabajo & Propósito',
                health: 'Salud & Bienestar',
                life: 'Vida Diaria',
                finance: 'Finanzas',
                mobility: 'Movilidad'
            };
            document.getElementById('evidence-category-title').textContent = `Logros: ${categoryNames[category]}`;

            // Cargar evidencias desde base de datos
            await loadEvidences(category);
            renderEvidenceSlider();
            modal.style.display = 'block';
        }

        // Cerrar modal de evidencias
        function closeEvidenceModal() {
            document.getElementById('evidenceModal').style.display = 'none';
        }

        // Subir evidencia
        async function uploadEvidence(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validar tipo de archivo
            if (!file.type.startsWith('image/')) {
                alert('Por favor selecciona un archivo de imagen válido');
                event.target.value = '';
                return;
            }

            // Validar tamaño (máximo 5MB)
            const maxSize = 5 * 1024 * 1024; // 5MB
            if (file.size > maxSize) {
                alert('La imagen es demasiado grande. Por favor selecciona una imagen menor a 5MB');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = async function(e) {
                try {
                    console.log('Subiendo imagen...', {
                        category: currentCategory,
                        size: file.size,
                        type: file.type
                    });

                    // Guardar en base de datos
                    const response = await fetch('api.php?action=upload_evidence', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            category: currentCategory,
                            image_data: e.target.result
                        })
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Error HTTP:', response.status, errorText);
                        alert('Error del servidor: ' + response.status);
                        return;
                    }

                    const responseText = await response.text();
                    console.log('Respuesta del servidor:', responseText.substring(0, 500));

                    let result;
                    try {
                        result = JSON.parse(responseText);
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        console.error('Respuesta completa:', responseText);
                        alert('Error: El servidor no devolvió JSON válido. Revisa la consola.');
                        return;
                    }

                    console.log('Resultado parseado:', result);

                    if (result.success) {
                        // Recargar evidencias desde la base de datos
                        await loadEvidences(currentCategory);
                        renderEvidenceSlider();
                        // Resetear input
                        event.target.value = '';
                        alert('¡Evidencia subida exitosamente!');
                    } else {
                        alert('Error al subir evidencia: ' + (result.message || 'Error desconocido'));
                    }
                } catch (error) {
                    console.error('Error al subir evidencia:', error);
                    alert('Error al subir evidencia. Por favor revisa la consola para más detalles.');
                }
            };

            reader.onerror = function() {
                alert('Error al leer el archivo');
                event.target.value = '';
            };

            reader.readAsDataURL(file);
        }

        // Renderizar slider de evidencias
        function renderEvidenceSlider() {
            const container = document.getElementById('evidenceSlider');
            const evidences = evidenceData[currentCategory] || [];

            if (evidences.length === 0) {
                container.innerHTML = '<div class="no-evidence">📸 Aún no tienes evidencias. ¡Sube la primera!</div>';
                return;
            }

            let sliderHTML = '<div class="slider-container">';
            sliderHTML += '<div class="slider-track" id="sliderTrack">';

            evidences.forEach((evidence, index) => {
                const date = new Date(evidence.date);
                const formattedDate = date.toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                sliderHTML += `
                    <div class="slider-item">
                        <img src="${evidence.image}" alt="Evidencia ${index + 1}" class="slider-image">
                        <button class="delete-evidence-btn" onclick="deleteEvidence(${evidence.id})">🗑️ Eliminar</button>
                        <div class="slider-caption">
                            Logro completado el ${formattedDate}
                        </div>
                    </div>
                `;
            });

            sliderHTML += '</div>';

            // Agregar controles de navegación si hay más de 1 evidencia
            if (evidences.length > 1) {
                sliderHTML += '<button class="slider-nav prev" onclick="changeSlide(-1)">❮</button>';
                sliderHTML += '<button class="slider-nav next" onclick="changeSlide(1)">❯</button>';
            }

            sliderHTML += '</div>';

            // Agregar dots si hay más de 1 evidencia
            if (evidences.length > 1) {
                sliderHTML += '<div class="slider-dots">';
                evidences.forEach((_, index) => {
                    sliderHTML += `<span class="slider-dot ${index === currentSlideIndex ? 'active' : ''}" onclick="goToSlide(${index})"></span>`;
                });
                sliderHTML += '</div>';
            }

            container.innerHTML = sliderHTML;
            updateSliderPosition();
        }

        // Cambiar slide
        function changeSlide(direction) {
            const evidences = evidenceData[currentCategory] || [];
            currentSlideIndex += direction;

            if (currentSlideIndex < 0) {
                currentSlideIndex = evidences.length - 1;
            } else if (currentSlideIndex >= evidences.length) {
                currentSlideIndex = 0;
            }

            updateSliderPosition();
        }

        // Ir a un slide específico
        function goToSlide(index) {
            currentSlideIndex = index;
            updateSliderPosition();
        }

        // Actualizar posición del slider
        function updateSliderPosition() {
            const track = document.getElementById('sliderTrack');
            if (track) {
                track.style.transform = `translateX(-${currentSlideIndex * 100}%)`;
            }

            // Actualizar dots
            const dots = document.querySelectorAll('.slider-dot');
            dots.forEach((dot, index) => {
                if (index === currentSlideIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        // Eliminar evidencia
        async function deleteEvidence(evidenceId) {
            if (!confirm('¿Estás seguro de que quieres eliminar esta evidencia?')) {
                return;
            }

            try {
                const response = await fetch('api.php?action=delete_evidence', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: evidenceId
                    })
                });

                const result = await response.json();
                if (result.success) {
                    // Recargar evidencias desde la base de datos
                    await loadEvidences(currentCategory);

                    // Ajustar índice del slide si es necesario
                    if (currentSlideIndex >= evidenceData[currentCategory].length) {
                        currentSlideIndex = Math.max(0, evidenceData[currentCategory].length - 1);
                    }

                    renderEvidenceSlider();
                } else {
                    alert('Error al eliminar evidencia: ' + (result.message || 'Error desconocido'));
                }
            } catch (error) {
                console.error('Error al eliminar evidencia:', error);
                alert('Error al eliminar evidencia');
            }
        }

        // ========== ANIMACIÓN DE CONFETI ==========

        // Inicializar js-confetti
        const jsConfetti = new JSConfetti();

        function launchConfetti() {
            // Lanzar explosión de confeti con colores personalizados
            jsConfetti.addConfetti({
                confettiColors: ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe', '#00f2fe'],
                confettiRadius: 6,
                confettiNumber: 150,
            });
        }

        // ========== SUBIR PORTADA PERSONALIZADA ==========

        // Subir portada personalizada
        async function uploadCover(category, inputElement) {
            const file = inputElement.files[0];
            if (!file) return;

            // Validar tipo de archivo
            if (!file.type.startsWith('image/')) {
                alert('Por favor selecciona un archivo de imagen válido');
                inputElement.value = '';
                return;
            }

            // Validar tamaño (máximo 5MB)
            const maxSize = 5 * 1024 * 1024; // 5MB
            if (file.size > maxSize) {
                alert('La imagen es demasiado grande. Por favor selecciona una imagen menor a 5MB');
                inputElement.value = '';
                return;
            }

            // Crear FormData para enviar el archivo
            const formData = new FormData();
            formData.append('cover_image', file);
            formData.append('category', category);

            try {
                const response = await fetch('api.php?action=upload_cover', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Error HTTP:', response.status, errorText);
                    alert('Error del servidor: ' + response.status);
                    return;
                }

                const result = await response.json();

                if (result.success) {
                    alert('✅ Portada actualizada exitosamente');

                    // Actualizar la imagen de la portada en la tarjeta
                    const cardImage = document.querySelector(`.card-${category} .card-image`);
                    if (cardImage) {
                        cardImage.src = result.data.image_url;
                    }
                } else {
                    alert('❌ Error al subir la portada: ' + result.message);
                }

            } catch (error) {
                console.error('Error:', error);
                alert('❌ Error al subir la portada');
            }

            // Limpiar el input
            inputElement.value = '';
        }

        // Cargar portadas personalizadas al iniciar
        async function loadCustomCovers() {
            try {
                const response = await fetch('api.php?action=get_all_covers');
                if (!response.ok) return;

                const result = await response.json();
                if (!result.success) return;

                const covers = result.data;

                // Aplicar las portadas personalizadas a cada tarjeta
                for (const [category, imageUrl] of Object.entries(covers)) {
                    const cardImage = document.querySelector(`.card-${category} .card-image`);
                    if (cardImage && imageUrl) {
                        cardImage.src = imageUrl;
                    }
                }

            } catch (error) {
                console.error('Error al cargar portadas:', error);
            }
        }

        // Inicializar al cargar la página
        window.addEventListener('load', function() {
            loadData();
            loadCustomCovers();
        });
    </script>

</body>
</html>
