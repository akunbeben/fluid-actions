# Changelog

All notable changes to `inline-confirm` will be documented in this file.

## v0.3.0 - 2026-06-04

- feat: introduce hold-to-confirm action
- refactor: extract shared core traits and Blade partial for view resolution
- fix: store action configuration in viewData for clone compatibility and collision prevention
- fix(ui): prevent layout shift on inline actions and sync auto-close behavior
- fix: add strict types header to auto-generated stubs
- style: add static holding state outline for reduced motion
- chore: update IDE helper stubs for holdToConfirm macro
- chore: address audit findings
- docs: document holdToConfirm macro in README

## v0.2.3 - 2026-06-04

- chore: refactor IDE stub generator script

## v0.2.2 - 2026-06-04

- fix: update stub file to follow Filament return type pattern

## v0.2.1 - 2026-06-04

- feat: add IDE helper stubs

## v0.2.0 - 2026-06-03

- feat: support Action inside an ActionGroup (dropdown menus and button groups)
- fix: prevent glitch when the original modal should be not appear
- docs: added project banner
- chore: fix PHPStan unmatched ignored errors in CI

## 0.1.0 - 2026-06-03

- initial release
