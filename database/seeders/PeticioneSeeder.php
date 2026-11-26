<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\File;
use App\Models\Peticione;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as Archivos;

class PeticioneSeeder extends Seeder
{
    public function run(): void
    {
        $mario = User::where('email', 'mario@test.com')->firstOrFail();
        $ana = User::where('email', 'ana@test.com')->firstOrFail();

        $peticiones = [
            [
                'titulo' => 'Más médicos en los centros de salud de La Rioja',
                'descripcion' => 'Las listas de espera para atención primaria superan las dos semanas. Pedimos que se cubran las plazas vacantes y se refuercen los centros con más población.',
                'destinatario' => 'Consejería de Salud de La Rioja',
                'categoria' => 'Sanidad', 'autor' => $mario, 'estado' => 'aceptada',
                'firmantes' => 1240, 'imagenes' => ['listado-01.webp', 'detalle-01.webp'], 'firmas' => [$ana],
            ],
            [
                'titulo' => 'Urgencias pediátricas abiertas 24 horas',
                'descripcion' => 'Por la noche los niños tienen que ser atendidos en urgencias generales. Solicitamos un servicio de pediatría de guardia las 24 horas.',
                'destinatario' => 'Ministerio de Sanidad',
                'categoria' => 'Sanidad', 'autor' => $ana, 'estado' => 'aceptada',
                'firmantes' => 865, 'imagenes' => ['listado-02.webp'], 'firmas' => [$mario],
            ],
            [
                'titulo' => 'Ordenadores nuevos para los institutos públicos',
                'descripcion' => 'Muchos equipos de las aulas de informática tienen más de diez años. Pedimos un plan de renovación para que el alumnado pueda trabajar con herramientas actuales.',
                'destinatario' => 'Consejería de Educación',
                'categoria' => 'Educación', 'autor' => $mario, 'estado' => 'aceptada',
                'firmantes' => 532, 'imagenes' => ['listado-03.webp'], 'firmas' => [],
            ],
            [
                'titulo' => 'Bajar la ratio de alumnos por aula',
                'descripcion' => 'Con 30 alumnos por clase es imposible una atención personalizada. Proponemos un máximo de 20 alumnos en primaria y 25 en secundaria.',
                'destinatario' => 'Ministerio de Educación',
                'categoria' => 'Educación', 'autor' => $ana, 'estado' => 'aceptada',
                'firmantes' => 2103, 'imagenes' => ['listado-04.webp', 'detalle-02.webp'], 'firmas' => [$mario],
            ],
            [
                'titulo' => 'Proteger las riberas del Ebro',
                'descripcion' => 'Los vertidos y la falta de limpieza están dañando la flora y la fauna del río. Pedimos más controles y un plan de recuperación de las riberas.',
                'destinatario' => 'Confederación Hidrográfica del Ebro',
                'categoria' => 'Medio ambiente', 'autor' => $mario, 'estado' => 'aceptada',
                'firmantes' => 978, 'imagenes' => ['listado-05.webp'], 'firmas' => [$ana],
            ],
            [
                'titulo' => 'Más carriles bici en Logroño',
                'descripcion' => 'Queremos una red de carriles bici conectada y segura que una los barrios con el centro y los institutos.',
                'destinatario' => 'Ayuntamiento de Logroño',
                'categoria' => 'Medio ambiente', 'autor' => $ana, 'estado' => 'pendiente',
                'firmantes' => 0, 'imagenes' => ['listado-06.webp'], 'firmas' => [],
            ],
            [
                'titulo' => 'Prohibir el abandono de animales en verano',
                'descripcion' => 'Cada verano aumentan los abandonos. Pedimos campañas de concienciación y sanciones más duras para quien abandone a su mascota.',
                'destinatario' => 'Gobierno de España',
                'categoria' => 'Animales', 'autor' => $ana, 'estado' => 'aceptada',
                'firmantes' => 3410, 'imagenes' => ['listado-07.webp'], 'firmas' => [$mario],
            ],
            [
                'titulo' => 'Un refugio municipal para animales',
                'descripcion' => 'La protectora de la ciudad está desbordada. Solicitamos un refugio municipal con veterinario y programa de adopciones.',
                'destinatario' => 'Ayuntamiento de Logroño',
                'categoria' => 'Animales', 'autor' => $mario, 'estado' => 'aceptada',
                'firmantes' => 712, 'imagenes' => ['listado-08.webp'], 'firmas' => [],
            ],
            [
                'titulo' => 'Juzgados con más personal para agilizar juicios',
                'descripcion' => 'Hay juicios que tardan años en celebrarse por falta de personal. Pedimos más jueces y funcionarios en los juzgados saturados.',
                'destinatario' => 'Ministerio de Justicia',
                'categoria' => 'Justicia', 'autor' => $ana, 'estado' => 'aceptada',
                'firmantes' => 455, 'imagenes' => ['listado-09.webp'], 'firmas' => [],
            ],
            [
                'titulo' => 'Asistencia jurídica gratuita más accesible',
                'descripcion' => 'Los requisitos para obtener abogado de oficio dejan fuera a muchas familias. Pedimos revisar los límites de ingresos.',
                'destinatario' => 'Ministerio de Justicia',
                'categoria' => 'Justicia', 'autor' => $mario, 'estado' => 'pendiente',
                'firmantes' => 0, 'imagenes' => ['listado-10.webp'], 'firmas' => [],
            ],
            [
                'titulo' => 'Alquiler asequible para jóvenes',
                'descripcion' => 'Los jóvenes destinan más de la mitad de su sueldo al alquiler. Pedimos más vivienda pública en alquiler y ayudas para menores de 35 años.',
                'destinatario' => 'Ministerio de Vivienda',
                'categoria' => 'Vivienda', 'autor' => $ana, 'estado' => 'aceptada',
                'firmantes' => 4890, 'imagenes' => ['listado-11.webp', 'detalle-03.webp'], 'firmas' => [$mario],
            ],
            [
                'titulo' => 'Rehabilitar los edificios del Casco Antiguo',
                'descripcion' => 'Muchos edificios del Casco Antiguo están en mal estado. Pedimos ayudas para su rehabilitación y para recuperar viviendas vacías.',
                'destinatario' => 'Ayuntamiento de Logroño',
                'categoria' => 'Vivienda', 'autor' => $mario, 'estado' => 'aceptada',
                'firmantes' => 640, 'imagenes' => ['detalle-04.webp'], 'firmas' => [$ana],
            ],
        ];

        Archivos::ensureDirectoryExists(public_path('peticiones'));

        foreach ($peticiones as $indice => $datos) {
            if (Peticione::where('titulo', $datos['titulo'])->exists()) {
                continue;
            }

            $peticion = new Peticione();
            $peticion->fill([
                'titulo' => $datos['titulo'],
                'descripcion' => $datos['descripcion'],
                'destinatario' => $datos['destinatario'],
                'firmantes' => $datos['firmantes'] + count($datos['firmas']),
                'estado' => $datos['estado'],
            ]);
            $peticion->user()->associate($datos['autor']);
            $peticion->categoria()->associate(Categoria::where('nombre', $datos['categoria'])->firstOrFail());
            $peticion->created_at = now()->subDays($indice * 3);
            $peticion->save();

            foreach ($datos['imagenes'] as $num => $imagen) {
                $nombre = 'seed_' . $peticion->id . '_' . $num . '_' . $imagen;
                Archivos::copy(public_path('img/' . $imagen), public_path('peticiones/' . $nombre));

                $file = new File();
                $file->name = $nombre;
                $file->file_path = 'peticiones/' . $nombre;
                $file->peticione()->associate($peticion);
                $file->save();
            }

            foreach ($datos['firmas'] as $firmante) {
                $peticion->firmas()->attach($firmante->id);
            }
        }
    }
}
