=====================================================
TEMA: Defensoría Universitaria - UNSA
Desarrollado por: Anthony Moroccoire
=====================================================

Este tema requiere una configuración inicial para funcionar correctamente:

1. INSTALACIÓN DEL TEMA
   - Sube el archivo .zip desde Apariencia > Temas > Añadir nuevo.
   - Activa el tema "Defensoría Universitaria".

2. PLUGINS REQUERIDOS
   - Instalar y activar el plugin: Secure Custom Fields (SCF).
   *Nota: Los Custom Post Types (Noticias, Eventos, etc.) ya están integrados en el código.

3. IMPORTAR CAMPOS PERSONALIZADOS (SCF)
   - Ve a SCF > Tools > Import.
   - Selecciona el archivo JSON ubicado en la carpeta: /setup/scf-export-2026-03-20.json
   - Haz clic en "Import JSON".

4. CONFIGURACIÓN DE ENLACES (PERMALINKS)
   - Ve a Ajustes > Enlaces permanentes.
   - Selecciona la opción: "Nombre de la entrada".
   - Haz clic en "Guardar cambios". 
   (Esto es obligatorio para que las secciones de Noticias y Equipo no den error 404).

5. ASIGNAR MENÚS
   - Ve a Apariencia > Menús.
   - Crea un menú y asígnalo a las ubicaciones "Menú Principal" y "Menú Footer".

6. IMPORTAR CONTENIDO (DATOS DE PRUEBA)
   - Ve a Herramientas > Importar.
   - En la sección "WordPress", haz clic en "Instalar ahora" (si no está instalado) y luego en "Ejecutar el importador".
   - Selecciona el archivo: /setup/defensoria.WordPress.2026-03-20.xml
   - Sigue los pasos para asignar los autores y marca la casilla "Descargar e importar archivos adjuntos" para traer las imágenes.
=====================================================