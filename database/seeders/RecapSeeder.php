<?php

namespace Database\Seeders;

use App\Enums\RecapStatus;
use App\Models\Recap;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RecapSeeder extends Seeder
{
    public function run(): void
    {
        $recaps = [
            [
                'title' => 'Planificación del proyecto',
                'content' => 'Definir alcance y requisitos para la nueva plataforma',
                'date' => Carbon::now()->subDays(10),
                'status' => RecapStatus::DO
            ],
            [
                'title' => 'Investigación de tecnologías',
                'content' => 'Comparar diferentes frameworks y seleccionar la mejor opción',
                'date' => Carbon::now()->subDays(8)->addHours(3),
                'status' => RecapStatus::PROCESS
            ],
            [
                'title' => 'Diseño de base de datos',
                'content' => 'Crear diagrama ERD y definir relaciones entre tablas',
                'date' => Carbon::now()->subDays(6)->subHours(2),
                'status' => RecapStatus::TO
            ],
            [
                'title' => 'Reunión con stakeholders',
                'content' => 'Presentar avances y recibir feedback sobre el diseño propuesto',
                'date' => Carbon::now()->subDays(5),
                'status' => RecapStatus::DO
            ],
            [
                'title' => 'Desarrollo de API',
                'content' => 'Implementar endpoints para usuarios y autenticación',
                'date' => Carbon::now()->subDays(3)->addHours(5),
                'status' => RecapStatus::PROCESS
            ],
            [
                'title' => 'Testing de integración',
                'content' => 'Crear casos de prueba para validar funcionamiento de módulos',
                'date' => Carbon::now()->subDays(2),
                'status' => RecapStatus::TO
            ],
            [
                'title' => 'Optimización de rendimiento',
                'content' => 'Analizar puntos críticos y mejorar tiempos de carga',
                'date' => Carbon::now()->subDay()->addHours(2),
                'status' => RecapStatus::DO
            ],
            [
                'title' => 'Despliegue a producción',
                'content' => 'Preparar ambiente y configurar CI/CD para lanzamiento',
                'date' => Carbon::now(),
                'status' => RecapStatus::PROCESS
            ],
        ];

        foreach ($recaps as $recap) {
            Recap::create($recap);
        }
    }
}
