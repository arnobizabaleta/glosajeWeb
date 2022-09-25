document.addEventListener("DOMContentLoaded", () => {

    const product = [{
        id: 1,
        name: "boxer1",
        size: 'xl',
        color: 'azul',
        precio: 5000,
        img: '../assets/images/B1.jpg',
        cantidad: 5
    },
    {
        id: 2,
        name: "Pijama",
        size: 'm',
        color: "negro",
        precio: 6000,
        img: '../assets/images/B2.jpg',
        cantidad: 3
    },

    {
        id: 3,
        name: "Ejemplo 1",
        size: 'l',
        color: 'rojo',
        precio: 10000,
        img: "../assets/images/B3.jpg",
        cantidad: 50
    },

    {
        id: 4,
        name: "EJemplo 2",
        size: 'xxl',
        color: 'gris',
        precio: 8000,
        img: "../assets/images/p1.jpg",
        cantidad: 7
    },

    {
        id: 5,
        name: "EJemplo 3",
        size: 'xxl',
        color: 'negro',
        precio: 8000,
        img: "../assets/images/p2.jpg",
        cantidad: 7
    },

    {
        id: 6,
        name: "EJemplo 4",
        size: 'xxl',
        color: 'blanco',
        precio: 8000,
        img: "../assets/images/p3.jpg",
        cantidad: 7
    },

    {
        id: 7,
        name: "EJemplo 5",
        size: 'xxl',
        color: 'azul cielo',
        precio: 8000,
        img: "../assets/images/pijama1.jpg",
        cantidad: 7
    },

    {
        id: 8,
        name: "EJemplo 5",
        size: 'xxl',
        color: 'azul cielo',
        precio: 8000,
        img: "../assets/images/n1.jpg",
        cantidad: 7
    },

    ];

    const items = document.querySelector('#item');
    const eventos = document.querySelector("#eventos");
    let carrito = [];
    let seleccion = [];
    let fondo = "bg-light";
    const compras = document.querySelector("#compras");
    const total = document.querySelector("#totalItem");
    const contenido = document.querySelector("#carrito");
    const vaciar = document.querySelector("#botonVaciar");
    const iconoCarrito = document.querySelector("#iconoCarrito");

    function createProduct() {

        product.forEach((p) => {

            const div = document.createElement('div');
            div.classList.add('card', 'col-sm-3', "text-center");

            const body = document.createElement('div');
            body.classList.add('card-body');

            const img = document.createElement('img');
            img.setAttribute('src', p.img);
            img.style.width = "100px";
            img.style.height = "100px";

            const name = document.createElement('h2');
            name.classList.add('h2', 'card-title');
            name.textContent = p.name;

            const size = document.createElement('p');
            size.classList.add('card-text');
            size.textContent = `Talla: ${p.size}`;

            const color = document.createElement('p');
            color.classList.add('card-text');
            color.textContent = `Color: ${p.color}`;

            const cantidad = document.createElement('p');
            cantidad.classList.add('card-text');
            //cantidad.textContent = `Unidades disponibles: ${p.cantidad}`;
            cantidad.textContent = p.cantidad;

            const precio = document.createElement('p');
            precio.classList.add('card-text');
            precio.textContent = `Precio: $${p.precio}`;

            const boton = document.createElement("button");
            boton.classList.add("btn", "btn-info", "text-white", "funcion");
            boton.textContent = "Agregar al carrito";
            boton.setAttribute("data-ident", p.id);

            body.appendChild(img);
            body.appendChild(name);
            body.appendChild(size);
            body.appendChild(color);
            body.appendChild(cantidad);
            body.appendChild(precio);
            body.appendChild(boton);

            div.appendChild(body);
            items.appendChild(div);
        });
    }



    eventos.addEventListener('click', (evento) => {

        if (evento.target && evento.target.hasAttribute("data-ident")) {

            carrito.push(evento.target.getAttribute("data-ident")); //Agregar id del producto

            cr();
            mostrarCarrito();
        }

        else if (evento.target.hasAttribute("data-selection")) {

            seleccion.forEach((itemSelec) => {

                carrito = carrito.filter((itemCarrito) => {

                    return itemCarrito != itemSelec;
                });
            });


            mostrarCarrito();
            cr();
            seleccion = [];
        }

        else if (evento.target.hasAttribute("data-void")) {

            carrito = [];

            mostrarCarrito();
            cr();
        }
        //000000
        else if (evento.target && evento.target.hasAttribute("data-item")) {

            eliminarCarrito(evento);
        }
        else if (evento.target && evento.target.hasAttribute("data-itemsm")) {

            carrito.push(evento.target.dataset.itemsm);

            mostrarCarrito();
            cr();
        }
        else if (evento.target && evento.target.hasAttribute("data-itemrs")) {

            carrito.splice(carrito.indexOf(evento.target.dataset.itemrs), 1);

            mostrarCarrito();
            cr();
        }

        else if (evento.target && evento.target.hasAttribute("data-body")) {

            console.log("check: " + evento.target.value.toggle);
            seleccion.push(evento.target.dataset.body);

            console.log("Seleccion: " + seleccion);

            let validacion = [];
            seleccion.forEach((it) => {

                if (!validacion.includes(it)) {
                    validacion.push(it);
                }
                else {

                    validacion = validacion.filter((item) => {

                        return item != it;
                    });

                    /*const indice = seleccion.indexOf(item);
                    validacion.splice(indice, 1); Por si la necesito en algun momento :)*/
                }
            });
            seleccion = validacion;

            console.log("Seleccion2: " + validacion);

        }
    });

    iconoCarrito.addEventListener("click", () => {

        vaciar.classList.toggle("d-none");
    });


    function cr() {
        const carritoNoRepetido = [...new Set(carrito)];
        return compras.textContent = carritoNoRepetido.length;
    }


    function mostrarCarrito() {

        contenido.textContent = "";

        const carritoNoRepetido = [...new Set(carrito)];

        carritoNoRepetido.forEach(item => { //Recorrer id

            const productFilter = product.filter((productItem) => {
                return productItem.id === parseInt(item); //igualar id filtrada a la original( retorna un valor)

            });//1 == 1: yes

            const cantidadItem = carrito.reduce((num1, num2) => {

                if (num1 <= 0) {
                    return num1;

                } else {

                    return num2 === item ? num1 -= 1 : num1;
                }

            }, productFilter[0].cantidad); //1

            function compra() {

                return cantidadCompra = carrito.reduce((num1, num2) => {

                    if (num1 >= productFilter[0].cantidad) {
                        return num1;

                    } else {

                        return num2 === item ? num1 += 1 : num1;
                    }

                }, 0);
            }

            const div = document.createElement('div');
            div.classList.add("card", "col-sm-4", "text-center");

            const check = document.createElement("input");
            check.setAttribute("type", "checkbox");
            check.classList.add("form-check", "form-check-input", "bg-success");
            check.dataset.body = item;

            const img = document.createElement('img');
            img.classList.add("img-fluid");
            img.setAttribute('src', productFilter[0].img);

            const name = document.createElement('h2');
            name.classList.add('h2', "card-title");
            name.textContent = productFilter[0].name;

            const size = document.createElement('p');
            size.classList.add("card-text");
            size.textContent = `Talla: ${productFilter[0].size}`;

            const color = document.createElement('p');
            color.classList.add("card-text");
            color.textContent = `Color: ${productFilter[0].color}`;

            const cantidad = document.createElement('p');
            color.classList.add("card-text");
            cantidad.textContent = `Productos disponibles: ${cantidadItem}`;

            const cantidadC = document.createElement('p');
            cantidadC.classList.add("card-text");
            cantidadC.textContent = `Cantidad a comprar: ${compra()}`;

            const precio = document.createElement('p');
            precio.classList.add("card-text")
            precio.textContent = `Precio: $${productFilter[0].precio}`;

            const botonSm = document.createElement("button");
            botonSm.classList.add("btn", "btn-info", "text-white");
            botonSm.textContent = "+";
            botonSm.dataset.itemsm = item;
            //botonSm.addEventListener("click", compra);

            const botonRs = document.createElement("button");
            botonRs.classList.add("btn", "btn-primary", "text-white");
            botonRs.textContent = "-";
            botonRs.dataset.itemrs = item;

            const botonEl = document.createElement("button");
            botonEl.classList.add("btn", "btn-danger", "text-white", "eliminar");
            botonEl.textContent = "Eliminar";
            //botonEl.setAttribute("data-ident", item);
            botonEl.dataset.item = item;
            //console.log("boton" + botonEl.target.dataset.item);

            div.appendChild(img);
            div.appendChild(size);
            div.appendChild(color);
            div.appendChild(cantidad);
            div.appendChild(cantidadC);
            div.appendChild(precio);
            div.appendChild(name);
            div.appendChild(check);
            div.appendChild(botonRs);
            div.appendChild(botonSm);
            div.appendChild(botonEl);
            
            contenido.appendChild(div);
        });

        total.textContent = totalPrecio();
    }

    function eliminarCarrito(evento) {

        const id = evento.target.dataset.item;
        console.log(id);

        carrito = carrito.filter((carritoItem) => {

            return carritoItem != id;
        });


        mostrarCarrito();
        cr();
    }




    function totalPrecio() {

        return carrito.reduce((val1, val2) => {


            const item = product.filter((items) => {

                return items.id == parseInt(val2);
            });

            const indicador = parseInt(item[0].id);

            //const cantidad = ((product[parseInt(item[0].id) - 1].cantidad) * item[0].precio);
            const cantidad = item[0].precio * item[0].cantidad;
            console.log("Cantidad: " + cantidad);

            if (val1 <= cantidad) {

                return val1 + item[0].precio;

            } else {

                return val1;
            }


        }, 0).toFixed(2);
    }



    createProduct();
    mostrarCarrito();

});
