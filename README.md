# FreePBX Backblaze B2 Filestore Module

A FreePBX module that adds [Backblaze B2](https://www.backblaze.com/cloud-storage) as a storage destination in the Filestore module, using B2's S3-compatible API.

## Features

- Appears as a **Backblaze** tab in Filestore settings alongside S3, FTP, SSH, etc.
- Uses Backblaze B2's S3-compatible API — no extra PHP dependencies required
- Built-in connection test (API connectivity, credentials, write test)
- Works with bucket-scoped Application Keys (recommended for security)
- Supports all B2 regions: US West (Sacramento), US West (Phoenix), EU Central (Amsterdam)
- Self-signed with PJL Telecom's GPG key — auto-imports on install

## Requirements

- FreePBX 17+
- The **Filestore** module must be installed (ships with FreePBX by default)

## Installation

1. Download or clone this repo into your FreePBX modules directory:
   ```bash
   cd /var/www/html/admin/modules/
   git clone https://github.com/PJL-Telecom/FreePBX-B2-Filestore.git filestorebackblaze
   ```

2. Install the module:
   ```bash
   fwconsole ma install filestorebackblaze
   ```

3. Reload FreePBX:
   ```bash
   fwconsole reload
   ```

## Configuration

1. Navigate to **Admin > Filestore** in the FreePBX GUI
2. Click the **Backblaze** tab
3. Click **Add Backblaze B2 Bucket**
4. Fill in:
   - **Bucket Name** — your B2 bucket name
   - **B2 Region** — the region your bucket is in
   - **Application Key ID** — your B2 keyID
   - **Application Key** — your B2 applicationKey
   - **Path** — optional prefix within the bucket (e.g. `backups/freepbx`)
5. Click **Test Connection Settings** to verify
6. Submit and use as a backup destination

## Backblaze B2 Setup

1. Log into your [Backblaze B2 dashboard](https://secure.backblaze.com/b2_buckets.htm)
2. Create a bucket (Private recommended)
3. Create an Application Key scoped to that bucket with read/write permissions
4. Note the **keyID** and **applicationKey** (the key is only shown once)

## How It Works

This module installs as a standalone FreePBX module and creates a symlink in the Filestore module's `drivers/` directory. This allows Filestore to discover the Backblaze driver without modifying any signed Filestore files.

Under the hood, it uses the same AWS S3 SDK and Flysystem adapter that the built-in S3 driver uses, pointed at Backblaze's S3-compatible endpoint (`s3.<region>.backblazeb2.com`).

## License

GNU General Public License v3.0 — see [LICENSE](LICENSE) for details.
