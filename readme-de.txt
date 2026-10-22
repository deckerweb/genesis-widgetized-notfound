=== Genesis Widgetized Not Found & 404 ===
Contributors: daveshine
Tags: genesis, 404, widgets, search
Requires at least: 6.4
Tested up to: 7.1.3
Requires PHP: 8.1
Stable tag: 2.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Widgets für Genesis-404-Seiten und Suchen ohne Treffer, mit Suchformular und Shortcodes.

== Description ==

Mit dem Such-Widget bestimmst du Beschriftung, Platzhalter und Schaltfläche. Shortcodes platzieren das Formular oder aktive Widget-Bereiche in geeigneten Inhalten. bbPress erhält bei erfolglosen Forumsuchen einen eigenen Bereich. Die Gestaltung kommt aus deinem Child-Theme.

Unter Genesis → Nicht gefunden & 404-Seite wählst du die volle Inhaltsbreite für 404 und leere Suchen getrennt aus und passt den Standard-Suchhinweis an. Beide Layout-Optionen sind standardmäßig aus; ein leeres Textfeld verwendet den übersetzten Standard. Die Einstellungen gelten pro Website und bleiben beim Entfernen des Plugins erhalten.

GitHub-Updates fragen Release-Metadaten ab und laden bei einem Update das Paket herunter. Die Library zeigt ihren mitgelieferten Katalog lokal; Online-Katalogabfragen sind optional und standardmäßig aus. GitHub sieht bei externen Anfragen die anfragende IP-Adresse. Keine Telemetrie; kein GitHub-Konto oder Token erforderlich. Bei Problemen mit aktivem Git Updater diesen vorübergehend deaktivieren und danach bei Bedarf wieder aktivieren.

Die Einrichtungsübersicht zeigt die Anzahl zugewiesener Widgets, die Ausgabe bei leerem Bereich und einzelne Bearbeitungslinks, einschließlich bbPress bei registriertem Bereich. Die Anzahl garantiert keine sichtbare Ausgabe: Die Anzeigeregeln der Widgets gelten weiterhin. Widersprüchliche Regeln des Such-Widgets und eine Beschränkung auf angemeldete Nutzer werden erläutert. Die neuen Regeln Nur auf 404-Seiten und Nur bei Suchen ohne Treffer sind optional.

Frontend-Testlinks öffnen normale Anfragen in einem neuen Tab, zusätzlich zu den bisherigen Customizer-Vorschauen. Auch ausgeloggt testen; Such-Plugins und Weiterleitungen können das Ergebnis beeinflussen. Shortcodes lassen sich per Schaltfläche kopieren oder bei fehlendem Zwischenablagezugriff manuell markieren. Widget-Bereich-Shortcodes zeigen zugewiesene Widgets, keinen Startinhalt.

Der optionale 404-Startinhalt ist standardmäßig ausgeschaltet. Bei Aktivierung und leerem 404-Widget-Bereich erscheinen Überschrift und Erklärung sowie optional Suchformular und Startseitenlink. Leere Textfelder verwenden übersetzte Standardtexte. Zugewiesene 404-Widgets haben immer Vorrang; auch ein durch seine Anzeigeregel verborgenes Widget verhindert die Ausgabe für einen leeren Bereich. Nach Abschalten erscheint bei leerem 404-Bereich wieder die bisherige Genesis-Ausgabe. Der tatsächliche Aufruf einer fehlenden Seite behält den 404-Status. Alle Einstellungen gelten für die aktuelle Website.

== Installation ==

Lade das Plugin-ZIP hoch und aktiviere es. Genesis muss auf der jeweiligen Website als Parent-Theme aktiv sein. Öffne **Design → Widgets** und füge Inhalte in die beiden Bereiche ein. Bestehende Widget-IDs und Einstellungen bleiben bei einem Update erhalten.

== Frequently Asked Questions ==

= Wo füge ich Inhalte hinzu? =

Unter Genesis → Nicht gefunden & 404-Seite befinden sich Einrichtungsübersicht, Layout-Optionen, Suchhinweis und optionaler 404-Startinhalt. Die einzelnen Bearbeitungslinks oder Design → Widgets führen zur Widget-Zuweisung.

= Funktioniert das ohne Genesis? =

Die Seitenintegration benötigt Genesis als aktives Parent-Theme. Ohne Genesis pausiert sie sicher und erhält gespeicherte Widgets. Library und Updater bleiben verfügbar.

= Was passiert mit leeren Widget-Bereichen? =

Ein leerer 404-Bereich zeigt die Genesis-Ausgabe oder den ausdrücklich aktivierten 404-Startinhalt. Ein leerer Suchbereich zeigt Suchhinweis und Suchformular. bbPress behält bei leerem Widget-Bereich seine eigene Meldung. Zugewiesene Widgets haben Vorrang, auch wenn ihre Anzeigeregeln sie ausblenden.

= Welche Shortcodes gibt es? =

Verwende [gwnf-search] und [gwnf-widget-area area="404"]. Weitere Bereichswerte sind notfound und bbpress-notfound. Suchattribute: search_text, button_text, form_label, wrapper, class, post_type. Auf der Einstellungsseite stehen Kopierbuttons für das Suchformular und die beiden Hauptbereiche bereit; manuelles Markieren ist ebenfalls möglich. Bereichs-Shortcodes fügen keinen 404-Startinhalt ein.

= Unterstützt es Multisite? =

Ja. Widgets gehören zur jeweiligen Website. Netzwerkaktivierung ist möglich; Genesis-Funktionen laufen nur auf Websites mit Genesis. Gemeinsame Library-Einstellungen gelten für das Netzwerk. Theme-Bearbeiter verwalten Widgets, Netzwerkadministratoren netzwerkweite Plugin-Updates.

= Liefert eine 404-Seite weiterhin HTTP 404? =

Ja. WordPress und Genesis bestimmen den HTTP-Status. Das Plugin ändert den dargestellten Inhalt, ohne Umleitungen oder Soft-404-Verhalten.

= Was passiert beim Entfernen mit meinen Daten? =

Deaktivierung und Deinstallation erhalten Widget-Inhalte und die Darstellungseinstellungen dieser Website. Beim letzten Library-Host werden temporäre gemeinsame Library-Daten bereinigt; die optionale Löschung ihrer Einstellungen folgt dem eigenen Schalter. Andere Plugins und Inhalte werden nie gelöscht.

== Changelog ==

= 2.0.2 · 2026-10-22 =

* Behoben: deckerweb Updater auf 2.2.1 aktualisiert: GitHub-Updates verwenden auch dann die mitgelieferte Implementierung, wenn ein anderes Plugin zuerst einen älteren Updater lädt.

= 2.0.1 · 2026-10-21 =

* Verbessert: deckerweb Library und GitHub-Updater mit aktuellen Paket- und Kompatibilitätsprüfungen aktualisiert.
* Behoben: Ausgabeabsicherung in den Such-Widget-Einstellungen verbessert.
* Sonstiges: Benötigt PHP 8.1; WordPress 6.4 bleibt unterstützt. Bestehende Widgets und Einstellungen bleiben erhalten.

= 2.0.0 · 2026-10-15 =

* Neu: Einrichtungsübersicht mit Widget-Anzahl, Bearbeitungslinks und Sichtbarkeitshinweisen.
* Neu: Optionaler 404-Startinhalt mit eigener Überschrift, Erklärung, Suchformular und Startseitenlink.
* Neu: Getrennte Optionen für volle Inhaltsbreite bei 404 und erfolgloser Suche sowie ein eigener Suchhinweis.
* Neu: Direkte Frontend-Tests, kopierbare Shortcodes und Such-Widget-Regeln für 404 und erfolglose Suchen.
* Verbessert: Kompatibilität mit aktuellem WordPress, PHP und Genesis einschließlich Website-Einstellungen und Netzwerkaktivierung.
* Verbessert: Zugängliche Suchformulare, lokale Dokumentation, deutsche Übersetzungen und aktualisierte Banner und Icons.
* Behoben: Sicherere Widget-Eingaben, Shortcode-Ausgabe und bbPress-Integration für erfolglose Suchen.
* Sonstiges: Benötigt WordPress 6.4 und PHP 8.0. Bestehende Widgets und Einstellungen bleiben erhalten.
* Sonstiges: Vertrieb über GitHub mit deckerweb Library und Updater; die bisherige Library für Installationsempfehlungen wurde entfernt.

= 1.6.4 · 2019-05-04 =

* Neu: Diagnoseinformationen im Website-Zustand und Newsletter-Links.
* Verbessert: Kompatibilität mit WordPress 5.2, Empfehlungsbibliothek 1.4.0 und deutsche Übersetzungen.

= 1.6.3 · 2018-11-22 =

* Verbessert: Installationsanleitung, FAQ zum HTTP-Status und Empfehlungsbibliothek 1.2.1.
* Behoben: Darstellung beim Hinzufügen von Widgets in der Widget-Verwaltung und im Customizer.

= 1.6.2 · 2018-11-03 =

* Neu: Video mit Plugin-Rundgang.
* Verbessert: Empfehlungsbibliothek 1.2.0 mit Dark-Mode-Darstellung.

= 1.6.1 · 2018-10-01 =

* Neu: Updatehinweise auf der Plugins-Seite und Community-Support-Links.
* Verbessert: Empfehlungsbibliothek 1.1.0 und deutsche Übersetzungen.
