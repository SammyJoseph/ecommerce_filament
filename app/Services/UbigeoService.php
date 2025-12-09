<?php

namespace App\Services;

class UbigeoService
{
    /**
     * Get the shipping rate based on the department Ubigeo ID.
     *
     * @param string|null $departmentId
     * @return float
     */
    public function getShippingRate(?string $departmentId): float
    {
        if (!$departmentId) {
            return 0.00;
        }

        return match ($departmentId) {
            '3926' => 15.00, // Lima
            '3606', '2625' => 20.00, // Ica, Ancash
            '3788', '3884', '4236', '4551', '2900', '4180', '4519' => 25.00, // Costa Lejana
            '3143', '3518', '4204', '3655', '3414', '3020', '2812', '3292', '4309' => 30.00, // Sierra
            '2534', '4108', '4431', '4567', '4165' => 35.00, // Selva
            default => 35.00,
        };
    }

    /**
     * Get all departments.
     *
     * @return array
     */
    public function getDepartments(): array
    {
        $path = storage_path('app/ubigeo/departamentos.json');
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true) ?? [];
        }
        return [];
    }

    /**
     * Get provinces for a specific department.
     *
     * @param string|null $departmentId
     * @return array
     */
    public function getProvinces(?string $departmentId): array
    {
        if (!$departmentId) {
            return [];
        }

        $path = storage_path('app/ubigeo/provincias.json');
        if (file_exists($path)) {
            $allProvinces = json_decode(file_get_contents($path), true);
            return $allProvinces[$departmentId] ?? [];
        }
        return [];
    }

    /**
     * Get districts for a specific province.
     *
     * @param string|null $provinceId
     * @return array
     */
    public function getDistricts(?string $provinceId): array
    {
        if (!$provinceId) {
            return [];
        }

        $path = storage_path('app/ubigeo/distritos.json');
        if (file_exists($path)) {
            $allDistricts = json_decode(file_get_contents($path), true);
            return $allDistricts[$provinceId] ?? [];
        }
        return [];
    }

    /**
     * Find department ID by name.
     *
     * @param string $name
     * @return string|null
     */
    public function getDepartmentIdByName(string $name): ?string
    {
        $departments = $this->getDepartments();
        $dept = collect($departments)->firstWhere('nombre_ubigeo', $name);
        return $dept['id_ubigeo'] ?? null;
    }

    /**
     * Find province ID by name within a department.
     *
     * @param string|null $departmentId
     * @param string $name
     * @return string|null
     */
    public function getProvinceIdByName(?string $departmentId, string $name): ?string
    {
        if (!$departmentId) return null;
        
        $provinces = $this->getProvinces($departmentId);
        $prov = collect($provinces)->firstWhere('nombre_ubigeo', $name);
        return $prov['id_ubigeo'] ?? null;
    }

    /**
     * Find district ID by name within a province.
     *
     * @param string|null $provinceId
     * @param string $name
     * @return string|null
     */
    public function getDistrictIdByName(?string $provinceId, string $name): ?string
    {
        if (!$provinceId) return null;

        $districts = $this->getDistricts($provinceId);
        $dist = collect($districts)->firstWhere('nombre_ubigeo', $name);
        return $dist['id_ubigeo'] ?? null;
    }
}
