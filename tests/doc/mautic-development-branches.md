## Development process for Mautic for new API and UI tests

### 1. Overview

This document describes the branch structure being used to develop
an API and UI test framework for Mautic. At the moment there are not
automated API or end-to-end UI tests. Until the whole framework is
properly ready, ongoing incremental changes are not going to be merged into
the main Mautic code. So there needs to be a separate "feature" branch
structure in place.

### 2. Existing Mautic branches

The main Mautic code at https://github.com/mautic/mautic has the following
branch workflow:

``staging`` - pull requests are made to staging, and merged once reviewed and tested.
``master`` - staging is merged up to master when code is ready for release.

### 3. Branches for API and UI test development

``ui-api-test-dev`` is branched from ``staging``. 
This contains the working, tested, "good" changes for the API and UI test development.
At regular intervals it will be rebased on ``staging`` to make sure that it keeps up
with other Mautic development. That will be done when there are no (or few) other pull request
branches depending on it.

``ui-api-doc`` is branched from ``staging``. This avoids seeing merge issues in the real code.
This contains documentation (like this document you are reading now) about the API and
UI test development. It is intended to contain helpful documentation and notes and is
not intended to be a final documentation for delivery. Final documentation would likely be
added to the developer documentation in https://github.com/mautic/developer-documentation

When developing new test infrastructure and test cases, branches are made from
``ui-api-test-dev`` and changes are done in those, e.g.:
```
git checkout ui-api-test-dev
git fetch origin
git pull
git checkout -b ui-test-xyz
```

Then work in that branch, adding and committing with commands like:
```
git status
git diff
git add -A
git commit -m "New good test case"
git push
```

### 4. GitHub

On GitHub, make a Pull Request from the branch with the new code, e.g. ``ui-test-xyz``
and make sure to change the target repository to be your own fork of Mautic (do not
make Pull Requests to the real Mautic repo just yet!) and to the ``ui-api-test-dev``
branch.

Self-review the code, and "Rebase and merge" the changes.
(when there are more people participating, then an independent review process can happen)

Remember to then pull the latest ``ui-api-test-dev`` changes back down to the localhost
repository:
```
git checkout ui-api-test-dev
git fetch origin
git pull
```

When ``ui-api-test-dev`` is fairly stable, it can be rebased locally and forced up:
```
git rebase staging
git push -f
```

Note: doing this will break any branches off ``ui-api-test-dev`` - so only do it when 
pending work is resolved and merged.
