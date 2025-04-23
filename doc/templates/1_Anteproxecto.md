# Anteproxecto fin de ciclo

- [Anteproxecto fin de ciclo](#anteproxecto-fin-de-ciclo)
  - [1- Descrición do proxecto](#1--descrición-do-proxecto)
  - [2- Empresa](#2--empresa)
    - [2.1- Idea de negocio](#21--idea-de-negocio)
    - [2.2- Xustificación da idea](#22--xustificación-da-idea)
    - [2.3- Segmento de clientes](#23--segmento-de-clientes)
    - [2.4- Competencia](#24--competencia)
    - [2.5- Proposta de valor](#25--proposta-de-valor)
    - [2.6- Forma xurídica](#26--forma-xurídica)
    - [2.7- Investimentos](#27--investimentos)
      - [2.7.1- Custos](#271--custos)
      - [2.7.2- Ingresos](#272--ingresos)
    - [2.8- Viabilidade](#28--viabilidade)
      - [2.8.1- Viabilidade técnica](#281--viabilidade-técnica)
      - [2.8.2 - Viabilidade económica](#282---viabilidade-económica)
      - [2.8.3- Conclusión](#283--conclusión)
  - [3- Requirimentos técnicos](#3--requirimentos-técnicos)
  - [4- Planificación](#4--planificación)


## 1- Descrición do proxecto

O proxecto consistirá nunha páxina web na que os usuarios poderán descubrir eventos e quedadas relacionadas co mundo do motor. Estes eventos poden ser de distintos tipos: exposicións de coches clásicos, quedadas tuning, concentracións temáticas, etc.
O sistema permitirá aos usuarios rexistrarse, iniciar sesión, consultar os eventos dispoñibles e inscribirse como participantes se o seu coche cumpre cos requisitos do evento. Os usuarios poderán subir información sobre o seu vehículo (marca, modelo, ano) para validar automaticamente se poden participar nun evento específico.

A maiores, ofrecerase unha suscrición premium, que permitirá aos usuarios desbloquear a opción de crear os seus propios eventos.
**AQUÍ SOLO PONEMOS UN RESUMEN. LAS TECNOLOGÍAS SE PONEN EN REQUISITOS TÉCNICOS.**

**ESTO FUERA
Funcionalidades principais:
- CRUD de eventos.
- Inscrición a eventos con validación de compatibilidade do coche
- Roles de usuario: participante e organizador
- Login, rexistro e sistema de sesións
- Suscrición premium para creación de eventos**

Tecnoloxías:
- Frontend:
- HTML5, CSS3, JavaScript
- Prototipado con Figma

Backend:
- PHP
- Base de datos MariaDB

## 2- Empresa

### 2.1- Idea de negocio

> O produto é unha plataforma web dirixida a apaixonados do mundo do motor. A diferenza doutras redes sociais, esta estará especializada unicamente en quedadas e eventos de coches, cun sistema de xestión que permite aos usuarios tanto participar como organizar eventos, en función do seu tipo de conta.
>
> Ofrecerase unha versión gratuita con opción de participar nos eventos, e unha versión de pago (suscrición) para usuarios que desexen crear eventos propios.

### 2.2- Xustificación da idea

> A idea nace da crecente comunidade afeccionada ao motor, que adoita organizar quedadas a través das redes sociais, pero sen unha plataforma centralizada e funcional que xestione todo iso.
>
> Esta aplicación busca cubrir ese oco, ofrecendo unha web intuitiva e moderna para xestionar eventos de forma eficiente.
>
> Análisis DAFO:
> - Debilidades
>   - Posible dificultade de entrada se non se promociona ben a aplicación.
>   - Necesidade de control de spam ou eventos falsos.
> - Ameazas
>   - Competencia futura de redes sociais que integren funcionalidades similares.
>   - Dependencia de usuarios activos para manter a comunidade viva.
> - Fortalezas
>   - Nicho específico con moita paixón e fidelidade.
>   - Personalización avanzada dos eventos.
>   - Validación automática de compatibilidade de vehículos.
> - Oportunidades
>   - Posibilidade de monetización con plans premium.
>   - Integración con talleres, marcas ou patrocinadores.

### 2.3- Segmento de clientes

> O proxecto está orientado a:
> - Afeccionados ao motor (tuning, clásicos, racing, etc.).
> - Clubs de coches.
> - Organizadores de quedadas locais.
> - Empresas que queren patrocinar eventos do motor.
> 
> Tanto usuarios novos como organizadores poden participar da plataforma. Os que pagan a suscrición poden organizar eventos, mentres que todos poden participar se teñen un coche compatible.

### 2.4- Competencia

> Actualmente, os eventos de coches adoitan organizarse en redes sociais como Facebook, Instagram, ou WhatsApp, pero ningún ofrece unha plataforma especializada para a xestión real de eventos con inscrición, validación de vehículos e organización en detalle.
> 
> Hai apps como Eventbrite ou Meetup, pero son máis xerais e non teñen sistema de validación por vehículo, cousa que esta aplicación contaría.

### 2.5- Proposta de valor
> **Diferenciación fronte aos competidores:**
> A maioría das quedadas organízanse actualmente en redes sociais (Facebook, WhatsApp, Instagram) de forma informal e pouco estruturada.
> 
> Aplicacións como Eventbrite ou Meetup permiten crear eventos, pero non están adaptadas ao sector do motor nin permiten validar os vehículos dos participantes.
> 
> **Mellora fronte aos competidores:**
> Validación automática de coche: o sistema comproba se o coche do usuario cumpre os requisitos do evento.
> Roles diferenciados: participantes e organizadores, con funcionalidades específicas para cada un.
> Opción de suscrición para desbloquear ferramentas exclusivas como a creación de eventos personalizados.
> Deseño adaptado para usuarios apaixonados do mundo do motor, con filtros por tipo de evento, localización e vehículo.
> 
> **Por que mercarán ou contratarán este servizo?**
> Porque é unha ferramenta feita á medida dun público moi activo e comprometido.
> Porque resolve un problema real: a desorganización e dispersión das quedadas actuais.
> Porque ofrece vantaxes reais e exclusivas para os usuarios suscritos (creación de eventos, visibilidade).
> Porque permite crear unha identidade dentro da comunidade automobilística e pertencer a un espazo especializado, máis aló das redes sociais convencionais.

### 2.6- Forma xurídica

> Optaríase pola forma xurídica de empresario individual (autónomo) nun inicio, debido á sinxeleza administrativa e baixo custe inicial. Máis adiante, podería transformarse nunha sociedade limitada (SL) para escalar o proxecto.

### 2.7- Investimentos

#### 2.7.1- Custos
> **Custos fixos de variables**
> - Precios diseñador web por hora: 50 €/h
> - Dominio web: 10 € - 20 € anuais
> - Aloxamento web: 20 € - 40 € ó mes
> - Servidor e base de datos: 15 € - 30 € ó mes
> - Comercio electrónico: 300 € - 600 € ó mes
> - Licenza ou ferramentas web (Figma, etc.): 0 - 50 €
> - Ciberseguridade: 200 € - 300 €
> - Xestión de redes sociais: 1.000 € - 1.500 € ó mes
> 
> Total fixo estimado: 1.519,17 €	- 2.367,51 € ó mes
>
> **Impostos e custos sociais**
> - Imposto sobre Sociedades: Aproximadamente 250 € (se hai beneficios de 1.000 €).
> - IRPF: 190 € ó mes sendo autónomo.
> - Seguridade Social: 290 € ó mes.
> 
> Total: 250 € (Sociedades) + 190 € (IRPF) + 290 € (Seguridade Social) = 730 €

> **Total aproximado: 2.249,17 € - 3.097,51 € ó mes**

#### 2.7.2- Ingresos

> Contando con suscrición premium: 5 € ó mes
> Previsión: 50 usuarios premium no primeiro ano: 5 x 12 x 50 = 3.000 € anuais
> Publicidade/patrocinios opcionais: 500 € adicionais
> Total estimado: 3.500 €

### 2.8- Viabilidade

#### 2.8.1- Viabilidade técnica
> O proxecto é viable a nivel técnico. As tecnoloxías propostas son coñecidas e accesibles. Existen ferramentas gratuitas ou de baixo custo para a maioría de funcionalidades.

#### 2.8.2 - Viabilidade económica

> Con custos iniciais baixos e unha previsión modesta de usuarios premium, o proxecto podería autofinanciarse no primeiro ano.

#### 2.8.3- Conclusión

> - É viable? Sí, xa que é indispensable unha ferramenta así no mercado de hoxe en día e a importancia para transmitir o sentimento do motor.
> - Beneficios superiores a custos? Si, incluso cunha base de usuarios pequena.
> - É escalable? Si, con plans premium, eventos patrocinados ou app móbil.

## 3- Requirimentos técnicos

> - **Infraestructura:**
> - Precios diseñador web por hora: 50 €/h
> - Dominio web: 10 € - 20 € anuais
> - Aloxamento web: 20 € - 40 € ó mes
> - Servidor e base de datos: 15 € - 30 € ó mes
> - Comercio electrónico: 300 € - 600 € ó mes
> - Licenza ou ferramentas web (Figma, etc.): 0 - 50 €
> - Ciberseguridade: 200 € - 300 €
> - Xestión de redes sociais: 1.000 € - 1.500 € ó mes
> 
> Total fixo estimado: 1.519,17 €	- 2.367,51 € ó mes
>
> - **Backend**
>   - PHP 
>   - Framework como Laravel
>   - Base de datos en MariaDB
> 
> - **Frontend**
>   - HTML5, CSS3, JavaScript.
>   - Prototipado con Figma.
>   - Validación de formularios e uso de librerías JavaScript.

## 4- Planificación
> **Calendario**
>
> Fase 1: Anteproxecto -> 7 de abril
> 
> Fase 2: Análise (requerimentos do sistema) -> 10 - 21 de abril
> 
> Fase 3: Deseño -> 23 - 28 de abril
> 
> Fase 4: Codificación e probas -> 30 de abril - 2 de xuño
> 
> Fase 5: Implantación -> 2 - 9 de xuño

[**<-Anterior**](../../README.md)
