<?php
// Verificar si existe el parámetro 'form' en la URL
if (isset($_GET['form_empleado']) && $_GET['form'] == 'add') { ?>
    <div class="container-fluid">
        <!-- Encabezado de página -->
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-plus-circle"></i> Agregar Empleado
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="view.php">Empleados</a></li>
            <li class="breadcrumb-item active">Agregar</li>
        </ol>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="proses.php?act=insert" method="POST" enctype="multipart/form-data">
                    <?php
                    require "../../../config/database.php";
                    // Generar el código automáticamente
                    $query_id = mysqli_query($mysqli, "SELECT MAX(id_empleado) as id FROM empleados") or die('Error ' . mysqli_error($mysqli));
                    $count = mysqli_num_rows($query_id);
                    if ($count <> 0) {
                        $data_id = mysqli_fetch_assoc($query_id);
                        $codigo = $data_id['id'] + 1;
                    } else {
                        $codigo = 1;
                    }
                    ?>
                    <div class="form-group">
                        <label for="codigo">Código de Empleado</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $codigo; ?>"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="nombre_empleado">Nombre</label>
                        <input type="text" class="form-control" id="nombre_empleado" name="nombre_empleado"
                            placeholder="" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            title="Solo se permiten letras y espacios" onkeypress="return soloLetras(event)" required>
                    </div>

                    <div class="form-group">
                        <label for="ape_empleado">Apellido</label>
                        <input type="text" class="form-control" id="ape_empleado" name="ape_empleado"
                            placeholder="" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            title="Solo se permiten letras y espacios" onkeypress="return soloLetras(event)" required>
                    </div>

                    <div class="form-group">
                        <label for="nro_ci_empleado">Número de Cédula</label>
                        <input type="text" class="form-control" id="nro_ci_empleado" name="nro_ci_empleado"
                            placeholder="" pattern="\d+" title="Solo se permiten números"
                            onkeypress="return soloNumeros(event)" required>
                    </div>

                    <div class="form-group">
                        <label for="mail_empleado">Correo electrónico</label>
                        <input type="email" class="form-control" id="mail_empleado" name="mail_empleado"
                            placeholder="Este correo se utilizará para el acceso al sistema" title="Debe ingresar un correo válido que contenga '@'"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="tel_empleado">Teléfono</label>
                        <input type="text" class="form-control" id="tel_empleado" name="tel_empleado"
                            placeholder="" pattern="\d+" title="Solo se permiten números"
                            onkeypress="return soloNumeros(event)" required>
                    </div>

                    <div class="form-group">
                        <label for="cargo_empleado">Cargo</label>
                        <input type="text" class="form-control" id="cargo_empleado" name="cargo_empleado"
                            placeholder="" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            title="Solo se permiten letras y espacios" onkeypress="return soloLetras(event)" required>
                    </div>

                    <div class="form-group">
                        <label for="direc_empleado">Dirección</label>
                        <input type="text" class="form-control" id="direc_empleado" name="direc_empleado" placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label for="salario_empleado">Salario</label>
                        <input type="text" class="form-control" id="salario_empleado" name="salario_empleado"
                            placeholder="" pattern="\d+" title="Solo se permiten números"
                            onkeypress="return soloNumeros(event)" required>
                    </div>

                    <div class="form-group">
                        <label for="direc_empleado">Fecha de ingreso</label>
                        <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label for="direc_empleado">Cargar CV del Empleado</label>
                        <input type="file" class="form-control" id="cv_empleado" name="cv_empleado"
                            placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label for="clausulas">Seleccione las cláusulas del contrato:</label><br>
                        <input type="checkbox" name="clausulas[]" value="Cláusula 1, Salario: 
                                El salario del empleado será de 2.680.373 Gs. mensuales, que se pagarán 
                                al final de cada mes. El pago se realizará mediante la banca Web de la Empresa, y estará sujeto a las deducciones legales aplicables, 
                                tales como impuestos, aportes a la seguridad social y otros conceptos establecidos por la ley.">
                                Cláusula 1: Salario<br> El salario del empleado será de 2.680.373 Gs. mensuales, que se pagarán al final de cada mes.
                                El pago se realizará mediante la banca Web de la Empresa, y estará sujeto a las deducciones legales aplicables,
                                tales como impuestos, aportes a la seguridad social y otros conceptos establecidos por la ley.<br>
                        <input type="checkbox" name="clausulas[]" value="Cláusula 2, Horario de Trabajo: 
                                El horario de trabajo será de 8 horas a la semana, distribuidas en 5 días de la semana, Lunes a viernes.
                                El horario laboral será de 08:00hs a 17:00hs, con una hora de descanso diario. Cualquier modificación al
                                horario deberá ser acordada por ambas partes con antelación.">Cláusula 2: Horario de Trabajo <br>
                                El horario de trabajo será de 8 horas a la semana, distribuidas en 5 días de la semana, Lunes a viernes.
                                El horario laboral será de 08:00hs a 17:00hs, con una hora de descanso diario. Cualquier modificación al horario
                                deberá ser acordada por ambas partes con antelación.<br>
                        <input type="checkbox" name="clausulas[]" value="Cláusula 3, Ausencias:
                                El empleado se compromete a informar con antelación cualquier ausencia laboral, ya sea por enfermedad, 
                                emergencia o cualquier otro motivo. En caso de ausencia no justificada, el empleador podrá aplicar sanciones de acuerdo 
                                con la normativa interna de la empresa. En caso de enfermedad, el empleado deberá presentar un justificante médico que respalde su inasistencia."> 
                                Cláusula 3, Ausencias: <br>
                                El empleado se compromete a informar con antelación cualquier ausencia laboral, ya sea por enfermedad, 
                                emergencia o cualquier otro motivo. En caso de ausencia no justificada, el empleador podrá aplicar sanciones de acuerdo 
                                con la normativa interna de la empresa. En caso de enfermedad, el empleado deberá presentar un justificante médico que respalde su inasistencia.<br>
                        <input type="checkbox" name="clausulas[]" value="Cláusula 4, Permisos:
                                El empleado tiene derecho a solicitar permisos de ausencia para asuntos personales, siempre que se solicite con suficiente antelación. 
                                Los permisos serán evaluados y autorizados por el empleador, y podrán ser remunerados o no, 
                                dependiendo de la política interna de la empresa y de la ley laboral vigente."> Cláusula 4, Permisos: <br>
                                El empleado tiene derecho a solicitar permisos de ausencia para asuntos personales, siempre que se solicite con suficiente antelación. 
                                Los permisos serán evaluados y autorizados por el empleador, y podrán ser remunerados o no, 
                                dependiendo de la política interna de la empresa y de la ley laboral vigente.<br>
                                <input type="checkbox" name="clausulas[]" value="Cláusula 5, Fecha de Cobro:
                                El salario se pagará a más tardar el [día] de cada mes. En caso de que dicho día coincida con un día no laborable, 
                                el pago se realizará el día laborable inmediatamente anterior."> Cláusula 5: Fecha de Cobro <br>
                                El salario se pagará a más tardar el [día] de cada mes. En caso de que dicho día coincida con un día no laborable, 
                                el pago se realizará el día laborable inmediatamente anterior. <br>
                                <input type="checkbox" name="clausulas[]" value="Cláusula 6, Fecha de Finalización del Contrato:
                                Este contrato tendrá una duración de [período de tiempo], comenzando el [fecha de inicio] y finalizando el [fecha de finalización].
                                 Cualquiera de las partes podrá terminar este contrato antes de la fecha estipulada, siempre que se cumplan las condiciones legales y
                                  contractuales correspondientes."> 
                                Cláusula 6, Fecha de Finalización del Contrato <br>
                                Este contrato tendrá una duración de [período de tiempo], comenzando el [fecha de inicio] y finalizando el [fecha de finalización]. 
                                Cualquiera de las partes podrá terminar este contrato antes de la fecha estipulada, siempre que se cumplan las condiciones legales y
                                contractuales correspondientes.<br>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de finalización del contrato</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" placeholder="" required>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                    <a href="view.php" class="btn btn-secondary">Cancelar</a>
                    <script>
                        // Permitir solo letras
                        function soloLetras(e) {
                            const key = e.key;
                            const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]$/; // Letras, acentos y espacios
                            if (!regex.test(key)) {
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        }

                        // Permitir solo números
                        function soloNumeros(e) {
                            const key = e.key;
                            const regex = /^[0-9]$/; // Solo números
                            if (!regex.test(key)) {
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
<?php
} else {
    // Si no existe 'form' en la URL o el valor no es válido, redirigir a la lista de ciudades
    header('Location: view.php');
}

?>