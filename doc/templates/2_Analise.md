# Requerimientos do sistema

- [Requerimientos do sistema](#requerimientos-do-sistema)
  - [1- Descrición Xeral](#1--descrición-xeral)
  - [2- Funcionalidades](#2--funcionalidades)
  - [3- Tipos de usuarios](#3--tipos-de-usuarios)
  - [4- Contorno operacional](#4--contorno-operacional)
  - [5- Normativa](#5--normativa)
  - [6- Melloras futuras](#6--melloras-futuras)

## 1- Descrición Xeral

> O proxecto consiste no desenvolvemento dunha plataforma web na que os usuarios poderán rexistrarse, crear un perfil cos datos do seu vehículo, consultar eventos do mundo do motor (quedadas, concentracións, exhibicións, etc.) e inscribirse neles sempre que cumpran os requisitos establecidos. Os usuarios tamén poderán, mediante suscrición, crear os seus propios eventos, moderalos e xestionar as inscricións doutros participantes.
>
> A páxina estará construída con tecnoloxías web (HTML, CSS, JavaScript, PHP e MariaDB) e terá un deseño responsive accesible desde dispositivos móbiles ou de escritorio.

## 2- Funcionalidades

| Acción   |  Descrición        |
|----------|--------------------|
| Rexistro de usuario	| Rexistro mediante formulario, gardando os datos do usuario e do seu vehículo.| 
| Inicio de sesión | Login con usuario e contrasinal, con validación segura.|
| Ver eventos dispoñibles |	Presentación de todos os eventos públicos activos, con filtros por zona, data ou tipo de evento.|
| Inscrición a eventos | Posibilidade de inscribirse nun evento se o vehículo cumpre os requisitos.|
| Creación de eventos | Usuarios con suscrición activa poderán crear eventos, definindo data, lugar, requisitos e límite de prazas.|
|Modificación/eliminación	| Os usuarios poderán editar ou eliminar os seus propios eventos ou datos persoais.|
|Validación de vehículos | O sistema comprobará se o vehículo do usuario inscrito cumpre os requisitos de participación no evento.|
| Panel de administración	| Para xestión por parte do administrador: xestionar usuarios, eventos, (bloquear contas) ou revisar contidos.|
|Sistema de suscrición | Integración dunha pasarela de pago para activar a opción de crear eventos.|
| Panel de perfil |	Sección de usuario onde poderá consultar eventos inscritos, eventos creados e modificar o perfil ou vehículo.|

## 3- Tipos de usuarios
> - Usuario anónimo: pode ver eventos dispoñibles, pero non inscribirse nin acceder a funcionalidades personalizadas.
>
> - Usuario rexistrado: pode inscribirse a eventos, editar o seu perfil, consultar eventos pasados e acceder a funcionalidades básicas.
> 
> - Usuario con subscrición: ten acceso adicional á creación de eventos e á xestión dos mesmos.
> 
> - Administrador: controla o sistema, pode eliminar eventos ou usuarios, moderar contidos e resolver incidencias.

## 4- Contorno operacional
> Para utilizar a aplicación web, os usuarios precisarán un navegador web actualizado (Chrome, Firefox, Edge, Safari...) e unha conexión a Internet estable.
A aplicación será compatible con móbiles e tablets, así como con ordenadores.
> 
> O sistema basearase nun servidor con soporte para PHP e base de datos MariaDB.

## 5- Normativa
> - [Aviso legal](https://www.motorlandaragon.com/es/aviso-legal.html)
> - [Política de privacidade](https://www.motorlandaragon.com/es/politica-de-privacidad).
> - [Política de cookies](https://www.motorlandaragon.com/es/politica-de-cookies.html).

## 6- Melloras futuras
> - Envío de emails de confirmación de inscricións e recordatorios de eventos próximos.
>
> - Sistema de puntuación e valoración de eventos.
> 
> - Chat interno entre participantes dun evento.
> 
> - Mapa interactivo con eventos por localización.
> 
> - Integración con redes sociais para compartir eventos directamente.

[**<-Anterior**](../../README.md)
