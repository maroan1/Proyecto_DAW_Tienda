<?php

$html = "<body>
<header>
    <div id='logo'>
        <img src='img/logo.png' alt='logo de la compañia' width='120px'>
        XaxiVinilos
    </div>
    <h1 id='idFactura'>FACTURA#1909#</h1>
    <div id='cliente' class='datos'>
        <div><span>CLIENTE</span> Nombre Cliente</div>
        <div><span>DNI</span> 111111111A</div>
        <div><span>DIRECCIÓN</span> Dirección Factura</div>
    </div>
    <div id='empresa' class='datos'>
        <div>XaxiVinilos</div>
        <div>Carrer de la Reina Na Germana, 24,<br> 46005 València, Valencia</div>
        <div>969 999 999</div>
        <div><a href='mailto:xaxivinilos@mail.es'></a></div>
    </div>
</header>
<main>
    <table border=1>
        <thead>
            <th>ID</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Black Ice</td>
                <td>25€</td>
                <td>3</td>
                <td>75€</td>
            </tr>
            <tr>
                <td>5</td>
                <td>OST Contra</td>
                <td>23,45€</td>
                <td>1</td>
                <td>23,45€</td>
            </tr>
            <tr>
                <td class='total' colspan='4'>SUBTOTAL</td>
                <td>98,45€</td>
            </tr>
            <tr>
                <td class='total' colspan='4'>IVA 21%</td>
                <td>20,67€</td>
            </tr>
            <tr>
                <td class='total' colspan='4'>TOTAL</td>
                <td>119,12€</td>
            </tr>
        </tbody>
    </table>
    <div id='notas'>
        <div>NOTAS:</div>
        <div class='nota'>Tiene 30 días de compromiso para devolver el producto sin desperfectos (se comprueba el
            buen
            estado de nuestros productos antes de entregar).</div>
        <div class='nota'>Para devoluciones en compras online pongasé en contacto con nuestro servico de atención al
            cliente.</div>
    </div>
</main>
<footer>
    Factura creada por ordenador, valida sin firma ni sello.
</footer>
</body>"
;
