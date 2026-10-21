<?php

namespace CeiboDev\FilamentArgentina\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * VAT condition of the invoice recipient, with the ids ARCA uses in electronic invoicing
 * (FEParamGetCondicionIvaReceptor). Names are kept in Spanish, as printed on invoices.
 */
enum TaxCondition: int implements HasLabel
{
    case ResponsableInscripto = 1;
    case Exento = 4;
    case ConsumidorFinal = 5;
    case Monotributo = 6;
    case NoCategorizado = 7;
    case ProveedorDelExterior = 8;
    case ClienteDelExterior = 9;
    case Liberado = 10;
    case MonotributoSocial = 13;
    case NoAlcanzado = 15;
    case MonotributoTrabajadorIndependientePromovido = 16;

    public function getLabel(): string
    {
        return match ($this) {
            self::ResponsableInscripto => 'IVA Responsable Inscripto',
            self::Exento => 'IVA Sujeto Exento',
            self::ConsumidorFinal => 'Consumidor Final',
            self::Monotributo => 'Responsable Monotributo',
            self::NoCategorizado => 'Sujeto No Categorizado',
            self::ProveedorDelExterior => 'Proveedor del Exterior',
            self::ClienteDelExterior => 'Cliente del Exterior',
            self::Liberado => 'IVA Liberado – Ley N° 19.640',
            self::MonotributoSocial => 'Monotributista Social',
            self::NoAlcanzado => 'IVA No Alcanzado',
            self::MonotributoTrabajadorIndependientePromovido => 'Monotributo Trabajador Independiente Promovido',
        };
    }
}
