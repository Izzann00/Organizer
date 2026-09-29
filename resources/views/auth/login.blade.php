<!DOCTYPE html>
<html lang="ca">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Organizer - Login</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" >

        <style>

            body {
                background: linear-gradient(135deg, #0d6efd, #6ea8fe);
            }

            .login-card {
                border: none;
                border-radius: 20px;
                overflow: hidden;
            }

            .login-header {
                background: #0d6efd;
                color: white;
                padding: 35px 20px;
                text-align: center;
            }

            .login-icon {
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 15px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.15);
                font-size: 32px;
            }

            .login-body {
                padding: 35px;
            }

            .form-control {
                padding: 12px 15px;
            }

            .input-group-text {
                background-color: #f8f9fa;
            }

            .login-button {
                padding: 12px;
                font-weight: 600;
                border-radius: 10px;
            }

        </style>

    </head>

    <body>

        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                    <div class="card login-card shadow-lg">

                        <div class="login-header">

                            <div class="login-icon">
                                <i class="bi bi-kanban"></i>
                            </div>

                            <h2 class="fw-bold mb-1">
                                Organizer
                            </h2>

                            <p class="mb-0">
                                Gestiona els teus projectes fàcilment
                            </p>

                        </div>

                        <div class="login-body">

                            <h4 class="text-center fw-bold mb-1">
                                Benvingut de nou
                            </h4>

                            <p class="text-center text-muted mb-4">
                                Inicia sessió per continuar
                            </p>

                            @if ($errors->any())

                                <div class="alert alert-danger">

                                    <i class="bi bi-exclamation-triangle me-1"></i>

                                    {{ $errors->first() }}

                                </div>

                            @endif

                            <form method="POST" action="{{ route('login.store') }}">

                                @csrf

                                <div class="mb-3">

                                    <label for="name" class="form-label fw-semibold">
                                        Usuari
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>

                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Introdueix el teu usuari" required autofocus >

                                    </div>
                                </div>

                                <div class="mb-4">

                                    <label for="password" class="form-label fw-semibold">
                                        Contrasenya
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>

                                        <input type="password" class="form-control" id="password" name="password" placeholder="Introdueix la teva contrasenya" required >

                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 login-button" >
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Iniciar sessió
                                </button>

                            </form>

                            <div class="text-center mt-4">

                                <small class="text-muted">
                                    Organizer · Gestió de projectes
                                </small>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </body>
</html>