import requests
import json

resp = requests.get("https://api.elsevier.com/content/search/scopus?query=Yakutsk",
                    headers={'Accept':'application/json',
                             'X-ELS-APIKey': 'c951122905774b2a212c42fbb722659a'})

print (json.dumps(resp.json(),
                 sort_keys=True,
                 indent=4, separators=(',', ': ')))