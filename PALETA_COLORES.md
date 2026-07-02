# 🎨 Paleta de Colores del Sistema

## Colores Definidos

La paleta de colores del sistema ha sido configurada en `tailwind.config.js` y está disponible en todas las vistas.

### Colores Principales

| Color | Hex | Nombre | Uso |
|-------|-----|--------|-----|
| **Prussian Blue** | `#0B3954` | `prussian-blue` | Color principal, botones, enlaces, headers |
| **Metallic Seaweed** | `#087E8B` | `metallic-seaweed` | Hover states, acentos secundarios |
| **Beau Blue** | `#BFD7EA` | `beau-blue` | Fondos claros, textos sobre fondos oscuros |
| **Sizzling Red** | `#FF5A5F` | `sizzling-red` | Alertas, acciones importantes, acentos |
| **Lava** | `#C81D25` | `lava` | Errores críticos, acciones destructivas |

## Uso en Tailwind

Los colores están disponibles como clases de Tailwind:

```html
<!-- Fondo -->
<div class="bg-prussian-blue">...</div>
<div class="bg-metallic-seaweed">...</div>
<div class="bg-beau-blue">...</div>

<!-- Texto -->
<p class="text-prussian-blue">...</p>
<p class="text-metallic-seaweed">...</p>

<!-- Bordes -->
<div class="border-prussian-blue">...</div>

<!-- Focus/Hover -->
<button class="bg-prussian-blue hover:bg-metallic-seaweed focus:ring-prussian-blue">...</button>
```

## Aplicación en Componentes

### Botones
- **Primario**: `bg-prussian-blue hover:bg-metallic-seaweed`
- **Secundario**: `bg-gray-600 hover:bg-gray-700`
- **Peligro**: `bg-lava hover:bg-sizzling-red`

### Enlaces
- **Normal**: `text-prussian-blue`
- **Hover**: `hover:text-metallic-seaweed`

### Inputs
- **Focus**: `focus:border-prussian-blue focus:ring-prussian-blue`

### Badges/Estados
- **Éxito**: Verde (Tailwind default)
- **Advertencia**: Amarillo (Tailwind default)
- **Error**: `bg-lava` o `bg-sizzling-red`
- **Info**: `bg-prussian-blue` o `bg-metallic-seaweed`

## Gradientes

Los gradientes están disponibles para fondos:

```html
<div class="bg-gradient-to-br from-prussian-blue via-metallic-seaweed to-prussian-blue">
```

## Archivos Actualizados

- ✅ `tailwind.config.js` - Colores definidos
- ✅ `resources/views/auth/login.blade.php` - Diseño moderno aplicado
- ✅ `resources/views/auth/register.blade.php` - Diseño moderno aplicado
- ✅ `resources/views/components/primary-button.blade.php` - Colores actualizados
- ✅ `resources/views/components/text-input.blade.php` - Colores actualizados

## Notas

- Los colores están optimizados para accesibilidad (contraste WCAG)
- Prussian Blue y Metallic Seaweed son colores complementarios
- Beau Blue se usa para contraste sobre fondos oscuros
- Sizzling Red y Lava se usan para alertas y acciones críticas
