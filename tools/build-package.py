"""Build the installable ZIP without development or presentation archives."""
from pathlib import Path
import hashlib,zipfile
r=Path(__file__).resolve().parents[1]
out=Path.cwd()/"genesis-widgetized-notfound-2.0.2.zip"
root_files={"genesis-widgetized-notfound.php","uninstall.php","LICENSE","README.md","README-de.md","CHANGES.md","CHANGES-de.md","SECURITY.md","readme.txt","readme-de.txt"}
with zipfile.ZipFile(out,"w",zipfile.ZIP_DEFLATED) as z:
 for p in sorted(r.rglob("*")):
  if not p.is_file():continue
  rel=p.relative_to(r);parts=rel.parts
  keep=len(parts)==1 and rel.name in root_files
  if parts[0] in ["includes","css","js","templates"]:keep=True
  if parts[0]=="languages" and p.suffix in [".mo",".po",".pot"]:keep=True
  if parts[0]=="assets" and ((len(parts)==2 and rel.name in ["icon-128x128.png","icon-256x256.png","banner-772x250.png","banner-1544x500.png"]) or (len(parts)==3 and parts[1]=="licenses" and rel.name in ["Manrope-OFL.txt","Literata-OFL.txt"])):keep=True
  if parts[0]=="docs" and p.suffix in [".txt",".md"]:keep=True
  if keep:z.write(p,"genesis-widgetized-notfound/"+str(rel))
with zipfile.ZipFile(out) as z:assert z.testzip() is None
Path(str(out)+".sha256").write_text(hashlib.sha256(out.read_bytes()).hexdigest()+"  "+out.name+"\n")
print(out)
