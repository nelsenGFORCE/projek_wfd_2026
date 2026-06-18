<?php

namespace Database\Seeders;

use App\Enums\MovieStatus;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Studio;
use Illuminate\Database\Seeder;

class CinemaSeeder extends Seeder
{
    public function run(): void
    {
        $studios = collect([
            Studio::create(['studio_name' => 'Studio 1', 'capacity' => 80]),
            Studio::create(['studio_name' => 'Studio 2', 'capacity' => 80]),
            Studio::create(['studio_name' => 'Studio 3', 'capacity' => 60]),
            Studio::create(['studio_name' => 'Studio 4', 'capacity' => 60]),
        ]);

        foreach ($studios as $studio) {
            $this->generateSeats($studio);
        }

        $movies = [
            [
                'title' => 'Pengabdi Setan 2: Communion',
                'synopsis' => 'Setelah kejadian mengerikan di desa, keluarga kecil ini berusaha membangun kehidupan baru di kota. Namun, ibu mereka yang telah lama meninggal kembali menghantui mereka dengan cara yang lebih mengerikan dari sebelumnya.',
                'duration' => 115,
                'poster' => 'https://image.tmdb.org/t/p/w500/zN41DPmPhwmY1liFOYMvk2Csz9R.jpg',
                'genre' => 'Horror, Thriller',
                'status' => MovieStatus::NowShowing->value,
            ],
            [
                'title' => 'KKN di Desa Penari',
                'synopsis' => 'Sebuah kelompok mahasiswa KKN menghadapi terror di desa terpencil. Misteri demi misteri terungkap ketika mereka menemukan bahwa desa ini menyimpan rahasia gelap yang telah berlangsung selama puluhan tahun.',
                'duration' => 130,
                'poster' => 'https://image.tmdb.org/t/p/w500/aUVCm0xooidal3XUeAy0q7c5RwK.jpg',
                'genre' => 'Horror, Mystery',
                'status' => MovieStatus::NowShowing->value,
            ],
            [
                'title' => 'Avatar: The Way of Water',
                'synopsis' => 'Jake Sully dan keluarganya menghadapi ancaman baru di Pandora ketika suku Api yang agresif mulai menyerang suku-suku lain. Perang besar pun tak terelakkan di dunia Pandora.',
                'duration' => 180,
                'poster' => 'https://image.tmdb.org/t/p/w500/t6HIqrRAclMFX602HjnD6XiPV1Y.jpg',
                'genre' => 'Action, Adventure, Sci-Fi',
                'status' => MovieStatus::NowShowing->value,
            ],
            [
                'title' => 'Mission: Impossible - Dead Reckoning',
                'synopsis' => 'Ethan Hunt menghadapi misi terakhirnya ketika AI yang tak terkendali mengancam seluruh dunia. Segala kemampuannya akan diuji dalam misi yang paling berbahaya sepanjang karirnya.',
                'duration' => 163,
                'poster' => 'https://image.tmdb.org/t/p/w500/NNxYkU70HPurnNCSiCjYAmacwm.jpg',
                'genre' => 'Action, Adventure, Thriller',
                'status' => MovieStatus::NowShowing->value,
            ],
            [
                'title' => 'Agak Laen',
                'synopsis' => 'Empat sahabat yang bekerja di stasiun radio hantu di malam hari harus menghadapi situasi mengerikan ketika salah satu prank mereka berubah menjadi bencana nyata.',
                'duration' => 108,
                'poster' => 'https://image.tmdb.org/t/p/w500/bVEeqjMF5tHQhOdkqsE3NPoeXmS.jpg',
                'genre' => 'Comedy, Horror',
                'status' => MovieStatus::NowShowing->value,
            ],
            [
                'title' => 'Gundala',
                'synopsis' => 'Sancaka melawan kejahatan yang kini lebih terorganisir dan berbahaya. Dengan kekuatan petirnya, ia harus melindungi Jakarta dari ancaman yang bisa menghancurkan kota.',
                'duration' => 140,
                'poster' => 'https://image.tmdb.org/t/p/w500/zSev2PqMD7MEsOnYnSL1EZ1kqZ9.jpg',
                'genre' => 'Action, Superhero',
                'status' => MovieStatus::ComingSoon->value,
            ],
            [
                'title' => 'Interstellar',
                'synopsis' => 'Di masa depan di mana manusia telah membangun koloni di Mars, sebuah anomali misterius mengancam seluruh umat manusia. Sekelompok ilmuwan harus menyelesaikan teka-teki kosmis sebelum terlambat.',
                'duration' => 150,
                'poster' => 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
                'genre' => 'Sci-Fi, Thriller',
                'status' => MovieStatus::ComingSoon->value,
            ],
        ];

        foreach ($movies as $movieData) {
            $movie = Movie::create($movieData);

            if ($movie->status === MovieStatus::NowShowing->value) {
                $hours = [10, 13, 16, 19, 21];
                $selectedHours = collect($hours)->random(3)->sort()->values();

                foreach ($selectedHours as $hour) {
                    $studio = $studios->random();
                    Schedule::create([
                        'movie_id' => $movie->id,
                        'studio_id' => $studio->id,
                        'show_date' => now()->addDays(rand(0, 6))->toDateString(),
                        'start_time' => sprintf('%02d:00:00', $hour),
                        'ticket_price' => rand(4, 6) * 10000,
                    ]);
                }
            }
        }
    }

    private function generateSeats(Studio $studio): void
    {
        $rows = range('A', 'J');
        $seatsPerRow = (int) floor($studio->capacity / count($rows));
        $remainder = $studio->capacity % count($rows);

        foreach ($rows as $index => $row) {
            $count = $seatsPerRow + ($index < $remainder ? 1 : 0);

            if ($count === 0) {
                break;
            }

            for ($col = 1; $col <= $count; $col++) {
                Seat::create([
                    'studio_id' => $studio->id,
                    'seat_number' => $row . $col,
                ]);
            }
        }
    }
}
