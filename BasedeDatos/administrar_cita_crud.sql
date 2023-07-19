DROP PROCEDURE administrar_cita_crud;

DELIMITER $$
CREATE PROCEDURE administrar_cita_crud(IN _fecha DATE, IN _hora TIME, IN _usuario INT, IN _crud CHAR(1))
BEGIN

SET @_status = 'error';
SET @_mensaje = 'Error Fatal';

SET @_crud = _crud;
SET @_id = false;
SET @_reserva = 0;

## VERIFICAR LA EXISTENCIA DE USUARIO ##
SELECT true INTO @_id FROM usuarios WHERE id = _usuario LIMIT 1;


IF @_crud = 'c' AND @_id = true THEN /*CREAR UNA NUEVA CITA*/

	SET @_mensaje = 'Error 0014';

	INSERT INTO cita VALUES (NULL, _fecha, _hora, _usuario);
    
    SELECT MAX(LAST_INSERT_ID(id)) AS RESERVA FROM cita;
	SET @_reserva = LAST_INSERT_ID();

	SET @_status = 'success';
    SET @_mensaje = 'Cita creada con exito';

ELSE

	SET @_mensaje = 'Error Fatal: No existe usuario';

END IF;

SELECT @_status, @_mensaje, @_reserva;

END;