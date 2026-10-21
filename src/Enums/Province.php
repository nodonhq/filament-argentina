<?php

namespace CeiboDev\FilamentArgentina\Enums;

use Filament\Support\Contracts\HasLabel;

/** The 24 jurisdictions (23 provinces and the city of Buenos Aires), by ISO 3166-2 code. */
enum Province: string implements HasLabel
{
    case CiudadAutonomaDeBuenosAires = 'AR-C';
    case BuenosAires = 'AR-B';
    case Catamarca = 'AR-K';
    case Chaco = 'AR-H';
    case Chubut = 'AR-U';
    case Cordoba = 'AR-X';
    case Corrientes = 'AR-W';
    case EntreRios = 'AR-E';
    case Formosa = 'AR-P';
    case Jujuy = 'AR-Y';
    case LaPampa = 'AR-L';
    case LaRioja = 'AR-F';
    case Mendoza = 'AR-M';
    case Misiones = 'AR-N';
    case Neuquen = 'AR-Q';
    case RioNegro = 'AR-R';
    case Salta = 'AR-A';
    case SanJuan = 'AR-J';
    case SanLuis = 'AR-D';
    case SantaCruz = 'AR-Z';
    case SantaFe = 'AR-S';
    case SantiagoDelEstero = 'AR-G';
    case TierraDelFuego = 'AR-V';
    case Tucuman = 'AR-T';

    public function getLabel(): string
    {
        return match ($this) {
            self::CiudadAutonomaDeBuenosAires => 'Ciudad Autónoma de Buenos Aires',
            self::BuenosAires => 'Buenos Aires',
            self::Catamarca => 'Catamarca',
            self::Chaco => 'Chaco',
            self::Chubut => 'Chubut',
            self::Cordoba => 'Córdoba',
            self::Corrientes => 'Corrientes',
            self::EntreRios => 'Entre Ríos',
            self::Formosa => 'Formosa',
            self::Jujuy => 'Jujuy',
            self::LaPampa => 'La Pampa',
            self::LaRioja => 'La Rioja',
            self::Mendoza => 'Mendoza',
            self::Misiones => 'Misiones',
            self::Neuquen => 'Neuquén',
            self::RioNegro => 'Río Negro',
            self::Salta => 'Salta',
            self::SanJuan => 'San Juan',
            self::SanLuis => 'San Luis',
            self::SantaCruz => 'Santa Cruz',
            self::SantaFe => 'Santa Fe',
            self::SantiagoDelEstero => 'Santiago del Estero',
            self::TierraDelFuego => 'Tierra del Fuego, Antártida e Islas del Atlántico Sur',
            self::Tucuman => 'Tucumán',
        };
    }
}
