<?php

require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Lire le fichier Markdown
$markdownFile = __DIR__ . '/RAPPORT_PROFESSIONNEL.md';
if (!file_exists($markdownFile)) {
    die("Erreur : Le fichier RAPPORT_PROFESSIONNEL.md n'existe pas.\n");
}

$markdownContent = file_get_contents($markdownFile);

// Convertir Markdown en HTML
$parsedown = new \Parsedown();
$htmlContent = $parsedown->text($markdownContent);

// CSS pour le PDF
$css = '
<style>
    @page {
        margin: 2cm;
        margin-header: 1cm;
        margin-footer: 1cm;
    }
    
    body {
        font-family: "DejaVu Sans", Arial, sans-serif;
        font-size: 11pt;
        line-height: 1.6;
        color: #333;
    }
    
    h1 {
        color: #2c3e50;
        font-size: 24pt;
        margin-top: 20pt;
        margin-bottom: 15pt;
        border-bottom: 3px solid #3498db;
        padding-bottom: 10pt;
    }
    
    h2 {
        color: #34495e;
        font-size: 18pt;
        margin-top: 18pt;
        margin-bottom: 12pt;
        border-bottom: 2px solid #95a5a6;
        padding-bottom: 8pt;
    }
    
    h3 {
        color: #555;
        font-size: 14pt;
        margin-top: 15pt;
        margin-bottom: 10pt;
    }
    
    h4 {
        color: #666;
        font-size: 12pt;
        margin-top: 12pt;
        margin-bottom: 8pt;
    }
    
    p {
        margin-bottom: 10pt;
        text-align: justify;
    }
    
    ul, ol {
        margin-bottom: 10pt;
        padding-left: 25pt;
    }
    
    li {
        margin-bottom: 5pt;
    }
    
    code {
        background-color: #f4f4f4;
        padding: 2pt 4pt;
        border-radius: 3pt;
        font-family: "Courier New", monospace;
        font-size: 10pt;
    }
    
    pre {
        background-color: #f4f4f4;
        padding: 10pt;
        border-left: 4px solid #3498db;
        border-radius: 4pt;
        overflow-x: auto;
        margin-bottom: 15pt;
    }
    
    pre code {
        background-color: transparent;
        padding: 0;
    }
    
    blockquote {
        border-left: 4px solid #3498db;
        padding-left: 15pt;
        margin-left: 0;
        margin-right: 0;
        margin-bottom: 15pt;
        color: #555;
        font-style: italic;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15pt;
    }
    
    table th, table td {
        border: 1px solid #ddd;
        padding: 8pt;
        text-align: left;
    }
    
    table th {
        background-color: #3498db;
        color: white;
        font-weight: bold;
    }
    
    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    hr {
        border: none;
        border-top: 2px solid #ecf0f1;
        margin: 20pt 0;
    }
    
    strong {
        color: #2c3e50;
        font-weight: bold;
    }
    
    em {
        font-style: italic;
    }
    
    a {
        color: #3498db;
        text-decoration: none;
    }
    
    .page-break {
        page-break-before: always;
    }
    
    /* Styles spécifiques pour les sections */
    h1:first-of-type {
        margin-top: 0;
    }
    
    /* Amélioration des listes */
    ul ul, ol ol, ul ol, ol ul {
        margin-top: 5pt;
        margin-bottom: 5pt;
    }
</style>
';

// Construire le HTML complet
$fullHtml = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Professionnel - SantéPlus</title>
    ' . $css . '
</head>
<body>
    ' . $htmlContent . '
</body>
</html>';

// Configuration DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');

// Créer l'instance DomPDF
$dompdf = new Dompdf($options);
$dompdf->loadHtml($fullHtml, 'UTF-8');

// Configuration de la page
$dompdf->setPaper('A4', 'portrait');

// Rendre le PDF
$dompdf->render();

// Nom du fichier de sortie
$outputFile = __DIR__ . '/RAPPORT_PROFESSIONNEL.pdf';

// Sauvegarder le PDF
file_put_contents($outputFile, $dompdf->output());

echo "✅ PDF généré avec succès : RAPPORT_PROFESSIONNEL.pdf\n";
echo "📄 Fichier sauvegardé dans : " . $outputFile . "\n";
