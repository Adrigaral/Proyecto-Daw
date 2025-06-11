# FASE DE CODIFICACIÓN E PROBAS

- [FASE DE CODIFICACIÓN E PROBAS](#fase-de-codificación-e-probas)
  - [1- Codificación](#1--codificación)
  - [2- Prototipos](#2--prototipos)
  - [3- Innovación](#3--innovación)
  - [4- Probas](#4--probas)

> Este documento explica como se debe realizar a fase de codificación e probas.

## 1- Codificación

> Crea unha carpeta no teu repositorio e sube o código frecuentemente.
>
> Mentres se vai codificando a aplicación, iranse atopando problemas e haberá que ir modificando aspectos do deseño. Estes cambios tamén se deben recoller na documentación.

## 2- Prototipos

https://www.figma.com/design/ETQpwC0st35CET4WkJX7RR/MotorGal?node-id=0-1&t=ljElCbqlkGAsPIGC-1

## 3- Innovación

Aínda que o proxecto seguiu a estrutura do patrón MVC, que xa fora abordado durante o ciclo, introducín algunhas tecnoloxías novas que supuxeron certos retos e aprendizaxes.

En canto ao desenvolvemento frontend, utilicei Leaflet, unha librería de JavaScript especializada na visualización de mapas interactivos. Esta elección permitiume engadir funcionalidades de xeolocalización aos eventos da aplicación. O principal reto foi comprender o funcionamento básico da libraría, especialmente a integración cos datos procedentes da base de datos. Para iso, tiven que converter coordenadas almacenadas no backend en marcadores dinámicos no mapa, empregando JavaScript e chamadas AJAX.

Tamén empreguei Bootstrap, un framework CSS que facilita a creación de interfaces responsive. Aínda que xa tiña coñecementos básicos de HTML e CSS e algo de Bootstrap que aprendín nun curso fai un par de anos. O uso de Bootstrap permitiume mellorar o deseño visual da aplicación sen ter que desenvolver todo o estilo dende cero e recordar o fácil e divertido que é de usar.

Ambas tecnoloxías requiriron un proceso de aprendizaxe autónomo, consultando documentación oficial e exemplos. Grazas a iso, puiden integrar solucións modernas e mellorar a usabilidade e estética da aplicación.

## 4- Probas

Probas realizadas:
Rexistro e inicio de sesión: comprobouse que os formularios validan correctamente os datos e que se accede segundo o tipo de usuario.

Creación de eventos: testouse que un usuario pode crear eventos e que aparecen na lista de eventos activos ademáis de poder manipulalos.

Inscrición a eventos: verificouse que un usuario pode inscribirse a eventos nos que non participa como organizador.

Sistema de permisos: probouse que un usuario sen permisos non pode acceder a funcionalidades restrinxidas.

Mapa con Leaflet: comprobouse que os eventos aparecen situados correctamente no mapa.

Responsive con Bootstrap: testouse en diferentes tamaños de pantalla que o deseño se adapta correctamente.

Problemas atopados:
Marcadores no mapa non aparecían: solucionouse revisando o formato das coordenadas e revisando os datos que chegaban da base de datos.

Erro ao crear eventos sen campos obrigatorios: engadiuse validación en backend e frontend para evitar insercións incompletas.

Redireccións incorrectas ao iniciar ou pechar sesión: solucionouse controlando mellor a lóxica na páxina principal con $_SESSION e redireccións específicas segundo o estado da sesión.

Problemas co acceso directo a index.php: resolvéronse engadindo condicións no .htaccess e no controlador principal.

[**<-Anterior**](../../README.md)
