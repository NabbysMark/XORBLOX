# XORBLOX

<div align="center">
    <img src="/images/roblox_logo.png" alt="XORBLOX">
</div>
<hr>
<p align="center">
    <b>XORBLOX is a project that serves as a self-hosted version of legacy ROBLOX, aiming to replicate the May–June 2008 era.</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/php-8.2%2B-777bb4?style=flat-square&logo=php&logoColor=white" alt="php 8.2+">
</p>

# RCCService

In my opinion, it's REALLY easy!

1. Get RCCService. Choose version `0.3.784.0` from [this link](https://archive.org/download/rbxgssetup/RBXGSSetup_0.3.784.0.msi).

2. Once it's installed, open Command Prompt and type:

```bat
cd /d "C:\Program Files (x86)\ROBLOX Corporation"
rccservice.exe -console
```

Congratulations, you have started a copy of RCCService! If you'd like. put that copy onto a VPS or something to make it on a public ip, if you did that go into .dependencies and edit the RCC settings according to the ip and the port.

3. Get x32dbg and open it in Administrator Mode.

4. Load it in x32dbg and then go to symbols and press the little Az button.

5. Search for roblox.com, replace it with your domain (it has to be 10 characterss)

# Webserver

1. Use apache and ONLY apache to put this on a working webserver.

2. Rename main_example in .dependencies to main.php

3. Change the configuration to be linked to your domain instead.

# Client