<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments = [
            'Lima' => [
                'provinces' => ['Lima', 'Callao', 'Huaral', 'Cañete'],
                'districts' => ['Miraflores', 'San Isidro', 'Surco', 'La Molina', 'Barranco', 'San Borja', 'Pueblo Libre', 'Jesús María', 'Lince']
            ],
            'Arequipa' => [
                'provinces' => ['Arequipa', 'Camaná', 'Islay'],
                'districts' => ['Cercado', 'Cayma', 'Yanahuara', 'Cerro Colorado', 'Hunter', 'Jacobo Hunter']
            ],
            'Cusco' => [
                'provinces' => ['Cusco', 'Urubamba', 'Calca'],
                'districts' => ['Wanchaq', 'Santiago', 'San Sebastián', 'San Jerónimo']
            ],
            'La Libertad' => [
                'provinces' => ['Trujillo', 'Pacasmayo', 'Ascope'],
                'districts' => ['Trujillo', 'La Esperanza', 'El Porvenir', 'Víctor Larco']
            ],
            'Piura' => [
                'provinces' => ['Piura', 'Sullana', 'Paita'],
                'districts' => ['Piura', 'Castilla', 'Veintiséis de Octubre']
            ],
        ];

        $department = fake()->randomElement(array_keys($departments));
        $province = fake()->randomElement($departments[$department]['provinces']);
        $district = fake()->randomElement($departments[$department]['districts']);

        $references = [
            'Cerca del parque principal',
            'Frente a la iglesia',
            'A una cuadra del mercado',
            'Al costado de la comisaría',
            'Cerca de Plaza Vea',
            'Frente al colegio',
            'A dos cuadras del óvalo',
            'Cerca de Metro',
            'Esquina con farmacia',
            'Al lado del banco',
        ];

        $addressTypes = ['home', 'work', 'other'];

        return [
            'department' => $department,
            'province' => $province,
            'district' => $district,
            'address' => fake()->streetAddress(),
            'reference' => fake()->randomElement($references),
            'address_type' => fake()->randomElement($addressTypes),
            'is_default' => false, // Will be set manually when needed
        ];
    }
}
