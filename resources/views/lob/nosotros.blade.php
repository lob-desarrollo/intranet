@extends('layouts.app')

@push('css')
    @vite(['resources/css/nosotros.css'])
@endpush

@section('content')
    <section class="bg-light pt-5 pb-2">
        <div class="container mt-5">
            <div class="row">
                <div class="col-6">
                    <img src="{{ asset('media/01banner.jpg') }}" class="img-fluid" />
                </div>
                <div class="col-6">
                    <div class="contenidoTabla">
                        <div class="contenidoCelda">
                            <h3 class="subtitulo2">Nosotros</h3>
                            <h2 class="titulo2 mt-2">Somos una marca mexicana pensada e inspirada en ti.</h2>

                            <p class="mt-4">
                                En LOB nos dedicamos a ofrecer moda y calidad al mejor precio a través de nuestras colecciones inspiradas en las tendencias mundiales. El principal objetivo es inspirar nuestro cliente, facilitarle su compra y que siempre pueda encontrar la mejor opción de moda. Nuestra diversa gama de colecciones les permite vestir con un estilo propio; y de esta forma les brindamos la vanguardia en tendencias que reúnen cuatro características principales: Moda, Calidad, Innovación y Precio.
                            </p>
                            <p>
                                LOB celebra la juventud a cualquier edad con diseños siempre en tendencia para le mercado de México. Los productos que diseñamos son justo lo que nuestros clientes sueñan para sus ocasiones esperadas y su reacción al verlos es de sorpresa. 
                            <p>
                                Tenemos más de 40 años en el mercado de la moda, y contamos con más de 85 tiendas en los mejores centros comerciales de México; teniendo presencia en 28 estados de la República Mexicana. En LOB, queremos ser tú mejor opción en el mundo de la moda, te ofrecemos siempre los mejores productos, con la mejor calidad y vanguardia en el mercado. Comprometidos a seguir contribuyendo al desarrollo social y económico de México, generando fuentes de trabajo, además de ser la mejor alternativa de compra para nuestros Clientes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="bg-light clipTriangulo">
    </div>
    <section class="marginTop marginBottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contenidoTabla">
                        <div class="contenidoCeldaVertical">
                            <h3 class="subtitulo2">Nuestra</h3>
                            <h2 class="titulo2 mt-2">Filosofía</h2>

                            <p class="mt-4">
                                LOB celebra la juventud a cualquier edad con diseños siempre en tendencia para el mercado de México. Los productos que diseña son justo lo que sus clientes sueñan para sus ocasiones esperadas y su reacción al verlos es de sorpresa. Ofrecemos moda siempre pensando en el diseño, calidad, innovación y precio justo.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('media/04banner.jpg') }}" class="img-fluid" />
                </div>
            </div>
        </div>
    </section>
    <section class="paddingTop paddingBottom bg-light">
        <div class="row sinMargin">
            <div class="col-md-3">
                <div class="tarjeta2">
                    <div class="celdaTarjeta2">
                        <div class="tarjetaIcono">
                            <img src="{{ asset('media/crecimiento-de-beneficios.png') }}" class="img-fluid" />
                        </div>
                        <h2 class="tarjetaTitulo mt-2">Crecemos Contigo</h2>
                        <div class="tarjetaDescripcion mt-3">
                            Marca de Moda emblemática de México, con más de 30 años de experiencia en la industria del Retail. Con presencia en 21 estados de la república mexicana. Manufacturamos productos de calidad enfocados en los detalles.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tarjeta2">
                    <div class="celdaTarjeta2">
                        <div class="tarjetaIcono">
                            <img src="{{ asset('media/modista.png') }}" class="img-fluid" />
                        </div>
                        <h2 class="tarjetaTitulo mt-2">Propuesta de moda</h2>
                        <div class="tarjetaDescripcion mt-3">
                            Desarrollamos diseños propios y auténticos, con un fit único, pensado y adaptado para nuestro mercado, con un estilo fresco, joven, alegre y colorido. Siempre encontrarás propuestas para llevar en cada momento de tu día, trabajo, eventos sociales.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tarjeta2">
                    <div class="celdaTarjeta2">
                        <div class="tarjetaIcono">
                            <img src="{{ asset('media/molecular.png') }}" class="img-fluid" />
                        </div>
                        <h2 class="tarjetaTitulo mt-2">Conexión con la moda</h2>
                        <div class="tarjetaDescripcion mt-3">
                            Interactuamos con nuestros clientes de forma sencilla y cercana. Nuestras campañas son desarrolladas con un look inspirador y realista. La asesoría que otorgamos busca engrandecer tu estilo.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tarjeta2">
                    <div class="celdaTarjeta2">
                        <div class="tarjetaIcono">
                            <img src="{{ asset('media/amor.png') }}" class="img-fluid" />
                        </div>
                        <h2 class="tarjetaTitulo mt-2">Amor por lo que somos</h2>
                        <div class="tarjetaDescripcion mt-3">
                            Somos mexicanos, principales impulsores del talento mexicano. Mantenemos una visión global anclada a nuestras raíces. Reconocemos el trabajo y talento dentro y fuera del país de los mexicanos.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="barraImagenes">
        <div class="row sinMargin">
            <div class="col-3">
                <img src="{{ asset('media/01banner.jpg') }}" class="img-fluid" />
            </div>
            <div class="col-3">
                <img src="{{ asset('media/02banner.jpg') }}" class="img-fluid" />
            </div>
            <div class="col-3">
                <img src="{{ asset('media/03banner.jpg') }}" class="img-fluid" />
            </div>
            <div class="col-3">
                <img src="{{ asset('media/04banner.jpg') }}" class="img-fluid" />
            </div>
        </div>
    </section>
@endsection