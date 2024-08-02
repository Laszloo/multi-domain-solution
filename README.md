# SUMMARY

A few years ago, I worked on a project involving multiple sites/domains (more than 20). 
These sites shared the same database and business logic, but the code for each site was implemented repeatedly.

The customer used native PHP 5.3, and the code was riddled with bugs and code smells, 
making maintenance extremely difficult and leading to significant redundancy.

A comprehensive solution was needed to address the spaghetti code, fulfilling the following requirements:

- Modern principles (SOLID, DRY, CC, etc.)
- Consistent business logic across all sites (with slight variations)
- Modularity
- High performance

This simple and efficient solution meets all the above criteria, 
although it is a demo structure (with dummy logic) representing part of the original solution.


## About the structure

There are 3 sets in this structure:
- `www_upload`: shared among sites
- `domain.org|com|etc`: These are the document roots of the sites, and domains point to them. These nodes are soft links referring to the `/projex/public/` directory.
- `projex`: the entry point of the sites, containing logic and servicing the domains


## Concept

As you can see, the project root is the `projex` directory, although the full domain structure is included to represent the whole solution. 
The basic concept is primarily modularity.

1. Add a new domain (e.g., `test.org`) to `projex/app/domainpreloader.php`.
2. Create a new config directory (if needed): `projex/app/TestOrg` and a p`rojex/app/TestOrg/route.php` file (for SEO purposes). 
   - If necessary, create custom `projex/app/TestOrg/services.php` and `projex/app/TestOrg/repositories.php` files.
3. Create domain source: `projex/src/Domain/Sites/TestOrg` (you can use the example structures provided here).
4. Done.

Note that this approach (with various services and repositories) lays the foundation for modularity.


### Tips

- When using CSS preloader or custom .js/.ts files, consider separating the src/ directory into src/Backend and src/Frontend.
- If the domains have significantly different logic, it might be worth considering an alternative solution to manage the growth of the codebase.
- These files, which contain User dummy data, logic, and tests, can be deleted.

This solution focuses on very similar business logic with minor differences. Different design, different routes, 
but the data retrieval processes are largely the same.
