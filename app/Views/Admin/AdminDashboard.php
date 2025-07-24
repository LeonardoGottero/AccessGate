<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="<?= base_url('CSS/Admin.css') ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png')?>">
</head>
<body>
    <a href="<?= site_url('Account') ?>"><button class="back-button"><span>« Volver</span></button></a>
    <div class="separator"></div>
    <div class="content">
        <h1>Panel de administrador</h1>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
        <p><?= session()->getFlashdata('message') ?></p>
        <div class="options">
            <h3>¿Limpiar cuentas no verificadas?</h3><a href="<?= site_url('Admin/Clear') ?>"><button class="btn">Limpiar</button></a>
        </div>
        <div class="options">
            <h3>Administrar permisos de cuentas:</h3>
            <div class="search">
                <input type="text" class="search__input" placeholder="Buscar cuentas..." id="SearchBar" >
                <button class="search__button">
                    <img src="<?= base_url('Images/Search.svg')?>" alt="Search Icon" class="search__icon">
                </button>
            </div>
        </div>
        <div id="resultadosBusqueda">
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#SearchBar').on('keyup', function() {
                var searchTerm = $(this).val();
                if (searchTerm.length >= 2) {
                    $.ajax({
                        url: '<?php echo base_url('/Admin/Search'); ?>',
                        method: 'GET',
                        data: { term: searchTerm },
                        dataType: 'json',
                        success: function(data) {
                            var resultadosDiv = $('#resultadosBusqueda');
                            resultadosDiv.empty();
                            if (data.length > 0) {
                                $.each(data, function(index, Account) {
                                    resultadosDiv.append(
                                        '<div class="cuenta-item">' +
                                            '<strong>' + Account.accountname + '</strong> (ID: ' + Account.AccountId + ')<br><br>' +
                                            '<form class="update-role-form" data-accountid="' + Account.AccountId + '">' +
                                                '<label for="role-' + Account.AccountId + '">Rol:  </label>' +
                                                '<select id="role-' + Account.AccountId + '" name="newRole">' +
                                                    '<option value="Cliente" ' + (Account.rol === 'Cliente' ? 'selected' : '') + '>Cliente</option>' +
                                                    '<option value="Admin" ' + (Account.rol === 'Admin' ? 'selected' : '') + '>Admin</option>' +
                                                '</select>'+
                                                '<button class="botonconfirm" type="submit">Guardar Rol</button>' +
                                            '</form>' +
                                            '</div>'
                                    );
                                });
                            } else {
                                resultadosDiv.append('<p>No se encontraron cuentas.</p>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error en la búsqueda:", error);
                            $('#resultadosBusqueda').empty().append('<p>Error al buscar cuentas.</p>');
                        }
                    });
                } else {
                    $('#resultadosBusqueda').empty();
                }
            });

            $(document).on('submit', '.update-role-form', function(e) {
                e.preventDefault();
                var accountId = $(this).data('accountid');
                var newRole = $(this).find('select[name="newRole"]').val();

                $.ajax({
                    url: '<?php echo base_url('/Admin/UpdateAccountRole'); ?>',
                    method: 'POST',
                    data: { accountId: accountId, newRole: newRole },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al actualizar el rol:", error);
                        alert('Error al actualizar el rol de la cuenta.');
                    }
                });
            });
        });
    </script>
</body>
</html>