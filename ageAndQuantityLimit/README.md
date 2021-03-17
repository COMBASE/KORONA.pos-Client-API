# Age and Item Quantity Restriction

## Setup

1) Copy files to local POS or server
2) Edit ageAndQuantityVerification.html
- Check sectors and age limits
3) Make sure items have their pack quantity in the name (example: "Product ABC 1 pack" or "ABC 4 Pack")
4) Make sure sectors have their limit in the name ("My Sector max 4 packs" or "Test 6 pack limit")
5) Create External System Call
- Display URL: file:///path/to/ageAndQuantityVerification.html
(path needs to be adjusted)
6) Add external system call in POS profile to "On Total" or add directly to Total button

### Option Receipt Lock
In order to enable the receipt lock which prevents from being finalized without getting checked add the POS function "Set receipt finalization lock" to the total button. The ageAndQuantityVerification.html will remove the lock when all checks have passed. 

