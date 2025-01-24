import requests
import json

url = "https://api.indexnow.org/indexnow"
headers = {
    "Content-Type": "application/json; charset=utf-8"
}

payload = {
    "host": "voicegpt.chat",
    "key": "f296c5404b194139b17052c28f935c7b",
    "keyLocation": "https://voicegpt.chat/f296c5404b194139b17052c28f935c7b.txt",
    "urlList": [
        "https://voicegpt.chat",
        "https://voicegpt.chat/imprint/",
        "https://voicegpt.chat/privacy_policy/"
    ]
}

response = requests.post(url, headers=headers, data=json.dumps(payload))

print(response.status_code)
print(response.text)