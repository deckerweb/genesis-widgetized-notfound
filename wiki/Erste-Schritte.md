# Erste Schritte

[English](Home) · [Deutsch](Start)

1. Das installierbare Plugin-ZIP unter Releases herunterladen und über Plugins → Plugin hinzufügen → Plugin hochladen installieren.
2. Das Plugin auf einer Website mit Genesis als Parent-Theme aktivieren.
3. Genesis → Nicht gefunden & 404-Seite öffnen. Die Bereiche prüfen und über die einzelnen Bearbeitungslinks Widgets zuweisen.
4. Bei Bedarf volle Inhaltsbreite oder einen eigenen Suchhinweis einstellen. Für einen leeren 404-Bereich lässt sich optional der Startinhalt aktivieren.
5. Speichern und die Frontend-Testlinks verwenden. Das Ergebnis zusätzlich ausgeloggt prüfen.

Die bisherige Library für Installationsempfehlungen ist entfernt. Version 2.0.0 wird über GitHub vertrieben und enthält deckerweb Library und Updater. Gespeicherte Widgets und Einstellungen bleiben erhalten. Bei der Deinstallation werden weder Plugin-Einstellungen noch Widget-Inhalte gelöscht.

Die Einrichtungsübersicht zeigt die Anzahl zugewiesener Widgets, die Ausgabe bei leerem Bereich und einzelne Bearbeitungslinks, einschließlich bbPress bei registriertem Bereich. Die Anzahl garantiert keine sichtbare Ausgabe: Die Anzeigeregeln der Widgets gelten weiterhin. Widersprüchliche Regeln des Such-Widgets und eine Beschränkung auf angemeldete Nutzer werden erläutert. Die neuen Regeln Nur auf 404-Seiten und Nur bei Suchen ohne Treffer sind optional.

Frontend-Testlinks öffnen normale Anfragen in einem neuen Tab, zusätzlich zu den bisherigen Customizer-Vorschauen. Auch ausgeloggt testen; Such-Plugins und Weiterleitungen können das Ergebnis beeinflussen. Shortcodes lassen sich per Schaltfläche kopieren oder bei fehlendem Zwischenablagezugriff manuell markieren. Widget-Bereich-Shortcodes zeigen zugewiesene Widgets, keinen Startinhalt.

Der optionale 404-Startinhalt ist standardmäßig ausgeschaltet. Bei Aktivierung und leerem 404-Widget-Bereich erscheinen Überschrift und Erklärung sowie optional Suchformular und Startseitenlink. Leere Textfelder verwenden übersetzte Standardtexte. Zugewiesene 404-Widgets haben immer Vorrang; auch ein durch seine Anzeigeregel verborgenes Widget verhindert die Ausgabe für einen leeren Bereich. Nach Abschalten erscheint bei leerem 404-Bereich wieder die bisherige Genesis-Ausgabe. Der tatsächliche Aufruf einer fehlenden Seite behält den 404-Status. Alle Einstellungen gelten für die aktuelle Website.
