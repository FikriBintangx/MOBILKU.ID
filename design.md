# DESIGN.md

# DRIVE.X

### Premium Car Marketplace

Inspired by:

* Framer
* Nothing OS
* Teenage Engineering
* Apple Minimalism
* Dot Matrix Interface

Version: 2.0

---

# Design Vision

Membuat pengalaman jual beli mobil yang terasa seperti menggunakan produk teknologi premium.

Bukan sekadar marketplace mobil.

Tetapi sebuah platform digital modern dengan visual futuristik, minimalis, dan interaktif.

Keywords:

* Minimal
* Premium
* Clean
* Futuristic
* Dot Matrix
* White Space
* Interactive Motion

---

# Color System

## Primary

Pure White

```css
#FFFFFF
```

Digunakan untuk:

* Background utama
* Section
* Card

---

## Secondary

Soft Gray

```css
#F5F5F5
```

Digunakan untuk:

* Surface
* Container
* Input

---

## Text

```css
#111111
```

---

## Matrix Dot Accent

```css
#000000
```

Digunakan untuk:

* Dot Pattern
* Divider
* Hover Effect

---

# Typography

## Heading

Font:

* Space Grotesk

Weight:

700

---

## Body

Font:

* Inter

Weight:

400

---

## Dot Matrix Font

Font:

* DotGothic16
* Matrix Sans

Digunakan untuk:

* Counter
* Mileage
* Status

Contoh:

```txt
AVAILABLE
72.000 KM
2024
```

---

# Design Language

## Framer Style

Karakteristik:

* Banyak white space
* Rounded card
* Glass effect ringan
* Layout modular
* Motion halus

---

## Nothing OS Style

Karakteristik:

* Dot Matrix
* Monochrome
* Geometric Layout
* Industrial Design

---

# Homepage

## Hero Section

Full Width

Layout:

```txt
-----------------------------------
Drive.X

Find The Next
Generation Car

[ Browse Cars ]

Mercedes AMG
2024

●●●●●●●●●●●●●
-----------------------------------
```

Background:

* Putih polos

Decorative:

* Dot Matrix Pattern
* Thin Grid Lines

---

# Hero Animation

Anime.js

Animasi:

* Text Reveal
* Blur To Sharp
* Floating Car Image
* Dots Scanning

Durasi:

800ms

---

# Featured Cars

Layout:

Grid 3 Kolom

Card:

```txt
┌────────────────┐
│                │
│     CAR        │
│                │
├────────────────┤
BMW M4
2023

72.000 KM

Rp 1.2 M
└────────────────┘
```

Hover:

* Scale 1.02
* Dot Matrix Glow

---

# Marketplace Section

Filter:

* Brand
* Price
* Year
* Fuel
* Transmission

Visual:

Mirip Framer CMS

Clean

Monochrome

---

# Detail Car Page

Layout:

50/50

Kiri:

Foto mobil

Kanan:

Informasi

```txt
Toyota Supra

Rp 950.000.000

● AVAILABLE

Year
2023

Mileage
12.000 KM

Transmission
Automatic
```

---

# Dot Matrix Information

Status:

```txt
● AVAILABLE

● SOLD

● RESERVED
```

Menggunakan animasi blinking.

---

# Sell Your Car

Konsep:

Modern Dashboard

Card putih.

Input:

* Nama
* Merk Mobil
* Tahun
* Harga
* Foto

Style:

Nothing OS Form

---

# Dashboard Admin

Background:

Putih

Card:

Abu muda

Border:

1px solid black

Statistik:

```txt
TOTAL CARS

00125
```

Menggunakan font Dot Matrix.

---

# Motion System

Anime.js

## Fade

```javascript
opacity: [0,1]
```

---

## Slide

```javascript
translateY:[40,0]
```

---

## Dot Pulse

```javascript
scale:[1,1.3]
```

---

## Matrix Scan

Efek garis bergerak horizontal.

Terinspirasi dari:

Nothing Phone Glyph Interface.

---

# Components

## Button

Primary

```txt
[ Browse Cars ]
```

Background:

Black

Text:

White

Radius:

999px

---

## Card

Radius:

28px

Background:

White

Border:

1px solid #EAEAEA

---

## Input

Height:

56px

Radius:

16px

Border:

1px solid #DADADA

---

# Responsive

Desktop

1440px

---

Tablet

768px

---

Mobile

390px

---

# User Experience

Target Feeling:

Saat pengguna membuka website harus terasa seperti:

"Ini bukan website showroom mobil biasa."

Melainkan:

"Ini seperti website Apple, Framer, dan Nothing yang kebetulan menjual mobil."

---

# Visual References

* Framer.com
* Nothing.tech
* Linear.app
* Raycast.com
* Stripe.com
* Tesla.com

---

# Final Design Style

Framer × Nothing OS × Automotive Marketplace

White Background
Black Typography
Dot Matrix Interface
Premium Motion
Minimal Design
Future Technology Feeling
