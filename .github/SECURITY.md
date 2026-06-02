# Security Policy

If you discover a security issue, please email akunbeben@gmail.com instead of opening a public issue.

Security reports may include, but are not limited to:

- A confirmation bypass that executes an action without the expected second confirmation step.
- A case where `inlineConfirmation()` changes behavior for an unsupported action type instead of falling back to Filament's default modal behavior.
- Unsafe rendering of action labels, modal labels, or user-controlled content.
- Any vulnerability that affects dangerous or destructive Filament actions.

Please include:

- A clear description of the issue and impact.
- Steps to reproduce the issue.
- A minimal action definition or repository that demonstrates the problem.
- Filament, Livewire, Laravel, PHP, and package versions.
- Any known workaround.

Do not disclose the issue publicly until it has been reviewed and a fix or mitigation is available.
