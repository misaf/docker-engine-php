# Docker Engine API specifications

These Swagger 2.0 documents are the official versioned Engine API definitions
from `moby/moby`, pinned at commit:

```text
120f0f764d04ea9eae98a455fc3cd81e2ebb4641
```

Source path: `api/docs/v1.XX.yaml`.

The files are development inputs. The SDK never downloads or generates code at
runtime. Update the pinned revision deliberately, review the Moby Engine API
changelog, refresh checksums in `checksums.sha256`, then regenerate and run the
coverage and determinism checks.
