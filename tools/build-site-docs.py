"""Generate bilingual public Wiki and Pages documentation from maintained plugin content."""
from pathlib import Path
import json,re
r=Path(__file__).resolve().parents[1];d=json.loads((r/'docs/content.json').read_text());wiki=r/'wiki';wiki.mkdir(exist_ok=True);pages=r/'pages'
base='https://github.com/deckerweb/genesis-widgetized-notfound';raw='https://raw.githubusercontent.com/deckerweb/genesis-widgetized-notfound/master/'
for lang in ['en','de']:
 de=lang=='de';suffix='-de' if de else '';banner='![Genesis Widgetized Not Found & 404]('+raw+'assets/github-banner-'+lang+'.png)\n\n'
 links='[English](Home) · [Deutsch](Start)\n\n';name='Start' if de else 'Home'
 toc='- [Erste Schritte](Erste-Schritte)\n- [Fragen nach Themen](Fragen-nach-Themen)\n- [Vollständiger Änderungsverlauf](Aenderungsverlauf)\n' if de else '- [Getting started](Getting-started)\n- [FAQ by topic](FAQ-by-topic)\n- [Full changelog](Changelog)\n'
 slogan='Hilfreiche Inhalte, wenn nichts gefunden wird.' if de else 'Helpful content when nothing is found.'
 intro='Widget-Inhalte für 404-Seiten und erfolglose Suchen in klassischen Genesis-Themes. Mit Such-Widget, Shortcodes und optionalem 404-Startinhalt.' if de else 'Widget content for 404 pages and empty search results in classic Genesis themes. Includes a search widget, shortcodes and optional 404 starter content.'
 home='# Genesis Widgetized Not Found & 404\n\n'+banner+'**'+slogan+'**\n\n'+intro+'\n\n**Version '+d['version']+'** · WordPress ≥ 6.4 · PHP ≥ 8.1 · Genesis\n\n'+links+toc+'\n[Download]('+base+'/releases/latest) · [Support]('+base+'/issues) · [Security]('+base+'/security/advisories/new)\n'
 (wiki/(name+'.md')).write_text(home)
 quick='''1. Download the installable plugin ZIP from Releases and upload it under Plugins → Add Plugin → Upload Plugin.
2. Activate the plugin on a site using Genesis as its parent theme.
3. Open Genesis → Not Found & 404 Page. Review each area and follow its editing link to assign widgets.
4. Choose full-width layouts or a no-results message if needed. For an empty 404 area, optionally enable the starter content.
5. Save and use the frontend test links. Check the result while logged out as well.

The previous installer-recommendations library is removed. Version 2.0.0 is distributed through GitHub and includes the deckerweb Library and Updater. Older saved widgets and settings are preserved. No plugin settings or widget content are deleted on uninstall.''' if not de else '''1. Das installierbare Plugin-ZIP unter Releases herunterladen und über Plugins → Plugin hinzufügen → Plugin hochladen installieren.
2. Das Plugin auf einer Website mit Genesis als Parent-Theme aktivieren.
3. Genesis → Nicht gefunden & 404-Seite öffnen. Die Bereiche prüfen und über die einzelnen Bearbeitungslinks Widgets zuweisen.
4. Bei Bedarf volle Inhaltsbreite oder einen eigenen Suchhinweis einstellen. Für einen leeren 404-Bereich lässt sich optional der Startinhalt aktivieren.
5. Speichern und die Frontend-Testlinks verwenden. Das Ergebnis zusätzlich ausgeloggt prüfen.

Die bisherige Library für Installationsempfehlungen ist entfernt. Version 2.0.0 wird über GitHub vertrieben und enthält deckerweb Library und Updater. Gespeicherte Widgets und Einstellungen bleiben erhalten. Bei der Deinstallation werden weder Plugin-Einstellungen noch Widget-Inhalte gelöscht.'''
 title='Erste Schritte' if de else 'Getting started'
 (wiki/(title.replace(' ','-')+'.md')).write_text('# '+title+'\n\n'+links+quick+'\n\n'+d['comfort'][lang]+'\n')
 groups=[('Einrichtung' if de else 'Setup',[0,1,2,8,12]),('Alltag und Fehlersuche' if de else 'Everyday use and troubleshooting',[13,14,3,5]),('Multisite und Daten' if de else 'Multisite and data',[4,6]),('Anpassung und Entwicklung' if de else 'Customization and development',[7,9,10,11])]
 faq='# '+('Fragen nach Themen' if de else 'FAQ by topic')+'\n\n'+links
 for title,ids in groups:
  faq+='## '+title+'\n\n'
  for i in ids:
   item=d['faq'][i];faq+='### '+item[2 if de else 0]+'\n\n'+item[3 if de else 1]+'\n\n'
 (wiki/('Fragen-nach-Themen.md' if de else 'FAQ-by-topic.md')).write_text(faq)
 (wiki/('Aenderungsverlauf.md' if de else 'Changelog.md')).write_text((r/('CHANGES'+suffix+'.md')).read_text()+'\n'+links)
 front='---\nlayout: default\ntitle: "'+('Dokumentation' if de else 'Documentation')+'"\n---\n\n'
 publichome=home.replace(links,'[English](index.html) · [Deutsch](index-de.html)\n\n')
 for stem in ['Home','Start','Erste-Schritte','Getting-started','Fragen-nach-Themen','FAQ-by-topic','Aenderungsverlauf','Changelog']:
  publichome=publichome.replace(']('+stem+')',']('+base+'/wiki/'+stem+')')
 (pages/('index-de.md' if de else 'index.md')).write_text(front+publichome+'\n'+d['comfort'][lang]+'\n\n[Repository]('+base+') · [FAQ]('+base+'/wiki/'+('Fragen-nach-Themen' if de else 'FAQ-by-topic')+')\n')
(wiki/'_Sidebar.md').write_text('## English\n\n- [Home](Home)\n- [Getting started](Getting-started)\n- [FAQ by topic](FAQ-by-topic)\n- [Changelog](Changelog)\n- [Help and security](Help-and-security)\n\n## Deutsch\n\n- [Start](Start)\n- [Erste Schritte](Erste-Schritte)\n- [Fragen nach Themen](Fragen-nach-Themen)\n- [Änderungsverlauf](Aenderungsverlauf)\n- [Hilfe und Sicherheit](Hilfe-und-Sicherheit)\n')
(wiki/'_Footer.md').write_text('**Genesis Widgetized Not Found & 404 · Documentation / Dokumentation**\n\n[Wiki home / Wiki-Startseite]('+base+'/wiki) · [Repository]('+base+') · [Downloads & Releases]('+base+'/releases)\n\n[Help & bugs / Hilfe & Fehler]('+base+'/issues) · [Discussions / Austausch]('+base+'/discussions) · [Security / Sicherheit]('+base+'/blob/master/SECURITY.md)\n\n© 2012–2026 David Decker – DECKERWEB.  \nPlugin: [GPL v2 or later / GPL v2 oder höher](https://www.gnu.org/licenses/gpl-2.0.html).\n')


(wiki/'Help-and-security.md').write_text('# Help and security\n\n[English](Help-and-security) · [Deutsch](Hilfe-und-Sicherheit)\n\nFor questions and reproducible bugs, use [Issues]('+base+'/issues). Use [Discussions]('+base+'/discussions) for general questions and examples. Include plugin, WordPress, PHP and Genesis versions; omit passwords and private site data.\n\nReport vulnerabilities privately using [GitHub Security Advisories]('+base+'/security/advisories/new), following the [security policy]('+base+'/blob/master/SECURITY.md). Do not post security issues publicly. This also covers the embedded Library and Updater.\n')
(wiki/'Hilfe-und-Sicherheit.md').write_text('# Hilfe und Sicherheit\n\n[English](Help-and-security) · [Deutsch](Hilfe-und-Sicherheit)\n\nNutze [Issues]('+base+'/issues) für nachvollziehbare Fehler und [Discussions]('+base+'/discussions) für allgemeine Fragen und Beispiele. Nenne Plugin-, WordPress-, PHP- und Genesis-Version; veröffentliche keine Passwörter oder vertraulichen Website-Daten.\n\nMelde Sicherheitslücken privat über [GitHub Security Advisories]('+base+'/security/advisories/new). Beachte die [Sicherheitsrichtlinie]('+base+'/blob/master/SECURITY.md). Sicherheitsprobleme gehören nicht in öffentliche Issues. Der Meldeweg gilt auch für die eingebettete Library und den Updater.\n')

for p in wiki.glob("*.md"):
 p.write_text(p.read_text().rstrip()+"\n")
