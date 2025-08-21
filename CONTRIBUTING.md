\# Contributing Guide



\## Branch Strategy

\- main: production-ready code

\- dev: integration branch

\- feature/\*: har naya kaam alag branch (e.g., feature/add-footer)



\## Workflow

1\) feature/\* branch banao from dev

2\) code change karo, `git add` + `git commit`

3\) push branch to origin

4\) PR: base = dev, compare = feature/\*

5\) review/merge, phir feature branch delete



\## Commit Messages

type(scope): short summary

Examples:

\- docs: add CONTRIBUTING guide

\- feat(auth): add login form

\- fix(nav): correct mobile menu



\## Coding Basics

\- Small, focused commits

\- Clear PR title + description

\- No direct commits on main



