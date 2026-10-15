# Fragen nach Themen

[English](Home) · [Deutsch](Start)

## Einrichtung

### Wo füge ich Inhalte hinzu?

Unter Genesis → Nicht gefunden & 404-Seite befinden sich Einrichtungsübersicht, Layout-Optionen, Suchhinweis und optionaler 404-Startinhalt. Die einzelnen Bearbeitungslinks oder Design → Widgets führen zur Widget-Zuweisung.

### Funktioniert das ohne Genesis?

Die Seitenintegration benötigt Genesis als aktives Parent-Theme. Ohne Genesis pausiert sie sicher und erhält gespeicherte Widgets. Library und Updater bleiben verfügbar.

### Was passiert mit leeren Widget-Bereichen?

Ein leerer 404-Bereich zeigt die Genesis-Ausgabe oder den ausdrücklich aktivierten 404-Startinhalt. Ein leerer Suchbereich zeigt Suchhinweis und Suchformular. bbPress behält bei leerem Widget-Bereich seine eigene Meldung. Zugewiesene Widgets haben Vorrang, auch wenn ihre Anzeigeregeln sie ausblenden.

### Wie verwende ich ein Layout in voller Breite?

Aktiviere die entsprechende Option unter Genesis → Nicht gefunden & 404-Seite. Die Suchoption ändert nur Suchen ohne Treffer; erfolgreiche Suchen behalten ihr bisheriges Layout. Die Hilfsfunktionen __gwnf_layout_404_full_width und __gwnf_layout_searchnotfound_full_width bleiben verfügbar.

### Wie ändere ich den Standardtext bei erfolgloser Suche?

Gib unter Genesis → Nicht gefunden & 404-Seite normalen Text ein. Er erscheint nur, wenn der Widget-Bereich Suche ohne Treffer leer ist; das Suchformular bleibt sichtbar. Ein leeres Textfeld stellt den übersetzten Standard wieder her. Der bestehende Ausgabefilter bleibt verfügbar. Ohne Genesis liegt die Einstellungsseite unter Einstellungen.

## Alltag und Fehlersuche

### Wie prüfe ich das Ergebnis?

Die Frontend-Testlinks auf der Einstellungsseite öffnen eine normale Anfrage für eine fehlende Seite und eine Suche mit einem zufälligen Begriff. Die bisherigen Customizer-Vorschauen bleiben verfügbar. Das Ergebnis zusätzlich ausgeloggt prüfen. Such-Plugins oder Weiterleitungen können die Ausgabe beeinflussen.

### Warum ist ein zugewiesenes Such-Widget unsichtbar?

Die Anzeigeregel und die Beschränkung auf angemeldete Nutzer prüfen. Regeln für einzelne Beiträge oder Seiten passen nicht zu 404 oder erfolglosen Suchen. Global oder die passende neue Regel verwenden. Einrichtungsübersicht und gespeichertes Widget-Formular erläutern widersprüchliche Regeln. Ein verborgenes zugewiesenes Widget zählt nicht als leerer Bereich.

### Welche Shortcodes gibt es?

Verwende [gwnf-search] und [gwnf-widget-area area="404"]. Weitere Bereichswerte sind notfound und bbpress-notfound. Suchattribute: search_text, button_text, form_label, wrapper, class, post_type. Auf der Einstellungsseite stehen Kopierbuttons für das Suchformular und die beiden Hauptbereiche bereit; manuelles Markieren ist ebenfalls möglich. Bereichs-Shortcodes fügen keinen 404-Startinhalt ein.

### Liefert eine 404-Seite weiterhin HTTP 404?

Ja. WordPress und Genesis bestimmen den HTTP-Status. Das Plugin ändert den dargestellten Inhalt, ohne Umleitungen oder Soft-404-Verhalten.

## Multisite und Daten

### Unterstützt es Multisite?

Ja. Widgets gehören zur jeweiligen Website. Netzwerkaktivierung ist möglich; Genesis-Funktionen laufen nur auf Websites mit Genesis. Gemeinsame Library-Einstellungen gelten für das Netzwerk. Theme-Bearbeiter verwalten Widgets, Netzwerkadministratoren netzwerkweite Plugin-Updates.

### Was passiert beim Entfernen mit meinen Daten?

Deaktivierung und Deinstallation erhalten Widget-Inhalte und die Darstellungseinstellungen dieser Website. Beim letzten Library-Host werden temporäre gemeinsame Library-Daten bereinigt; die optionale Löschung ihrer Einstellungen folgt dem eigenen Schalter. Andere Plugins und Inhalte werden nie gelöscht.

## Anpassung und Entwicklung

### Wie gestalte ich die Widget-Bereiche?

Verwende Child-Theme-CSS mit #gwnf-404-area, #gwnf-notfound-area und .gwnf-bbpress-notfound-area. Die Aktion gwnf_load_styles erlaubt zusätzliche eingereihte Styles. Das Plugin speichert kein eigenes CSS.

### Kann ich Shortcodes abschalten?

Definiere GWNF_SHORTCODE_FEATURES vor init als false, um beide Plugin-Shortcodes abzuschalten. GWNF_NO_WIDGETS_SHORTCODE mit true schaltet die vom Plugin ergänzte Verarbeitung alter Text-Widgets ab. Die eigene Shortcode-Unterstützung moderner Text-Widgets bleibt unter WordPress-Kontrolle.

### Wie funktionieren die Suchattribute?

wrapper akzeptiert div, section, aside, nav und span; sonst wird div verwendet. class unterstützt mehrere CSS-Klassen mit Leerzeichen. post_type akzeptiert kommaseparierte, öffentlich durchsuchbare registrierte Inhaltstypen. Eine Beschriftung für Hilfstechnologien ist auch ohne eigenen Label-Text vorhanden.

### Welche Entwicklerfilter bleiben verfügbar?

Bestehende gwnf-Ausgabe-, Titel- und Beschreibungsfilter bleiben erhalten. Die vorgesehenen Bereichsbeschreibungsfilter gwnf/filter/widget_areas/404/description und gwnf/filter/widget_areas/notfound/description erhalten jetzt den jeweiligen Bereich. gwnf_filter_shortcode_widget_area filtert jetzt die gepufferte Ausgabe.
