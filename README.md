# Mejoras del Proyecto de Gestión de Clientes 🚀

## 1. Navegación de Detalles 🔍
- Implementación de botones "Siguiente" y "Anterior"
- Navegación fluida entre registros
- Mantiene el contexto de visualización

## 2. Validación de Datos ✅
- Verificación de correo electrónico único
- Validación de formato de IP
- Control de formato de teléfono (999-999-9999)

## 3. Gestión de Imágenes de Clientes 🖼️
- Nomenclatura: 00000XXX.jpg
- Imagen por defecto con RoboHash
- Almacenamiento en directorio uploads

## 4. Subida de Imágenes 📤
- Formatos: JPG y PNG
- Límite de tamaño: 500 Kbps
- Subida opcional en nuevos registros

## 5. Información Geográfica 🌍
- Obtención de información de país con ip-api.com
- Visualización de bandera con Flagpedia
- Representación geográfica del cliente

## 6. Lista de Clientes Mejorada 📋
- Ordenación por:
  - Nombre
  - Apellido
  - Correo electrónico
  - Género
  - Dirección IP
- Navegación adaptativa

## 7. Generación de PDF 📄
- Botón "Imprimir" en detalles de cliente
- Exportación completa de información

## 8. Sistema de Autenticación 🔐
- Nueva tabla de usuarios
- Campos: Login, Password (encriptada), Rol
- Máximo 3 intentos de inicio de sesión
- Bloqueo temporal tras intentos fallidos

## 9. Control de Acceso por Rol 🛡️
- **Rol 0 (Visualización)**:
  - Lista de clientes
  - Detalles de clientes
- **Rol 1 (Administrador)**:
  - Todos los permisos de Rol 0
  - Modificación de registros
  - Eliminación de usuarios

## 10. Geolocalización 🗺️
- Integración con OpenLayers
- Visualización de ubicación por IP
- Mapa interactivo de localización

## 11. Logout 🚪
- Cierre de sesión seguro
- Redirección a página de login
- Limpieza de sesión y cookies

## 12. Mejora de Estilos 🎨
- Diseño responsive
- Tema de interfaz unificado
- Optimización de accesibilidad

## 13. Registro de Nuevos Usuarios 👥
- Formulario de registro independiente
- Validación de datos de usuario
- Creación de cuenta con rol predeterminado
- Verificación de credenciales únicas
