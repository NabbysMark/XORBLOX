# XORBLOX

<div style="text-align:center;">
    <img src="/images/roblox_logo.png" alt="XORBLOX">
</div>

XORBLOX is a project that serves as a self-hosted version of legacy ROBLOX, aiming to replicate the May–June 2008 era.

# Setup

In my opinion, it's REALLY easy!

1. Get RCCService. Choose version `0.3.784.0` from [this link](https://archive.org/download/rbxgssetup/RBXGSSetup_0.3.784.0.msi).

2. Once it's installed, open Command Prompt and type:

```bat
cd /d "C:\Program Files (x86)\ROBLOX Corporation"
rccservice.exe -console
```

Congratulations, you have started a copy of RCCService! If you'd like. put that copy onto a VPS or something to make it on a public ip, if you did that go into .dependencies and edit the RCC settings according to the ip and the port.

3. Use apache and ONLY apache to put this on a working webserver.

# Client

