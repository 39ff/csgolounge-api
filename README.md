CSGO Lounge API
---

How output looks like:

```
{ 
   "2452":{                    // Match ID
      "live":true,             // Live status
      "time":"17 minutes ago", // Time
      "event":"Faceit",        // Event name
      "teams":[  
         {  
            "name":"LGB",      // Name (Team 1)
            "percent":"28%"    // Percent (Team 1)
         },
         {  
            "name":"EnVyUs",   // Name (Team 2)
            "percent":"72%"    // Percent (Team 2)
         }
      ],
      "result":{  
         "status":"won",       // Result of the match
         "team":1              // Team that won
      }
   }
}
```

Things I used:

* http://php.net/manual/en/function.strip-tags.php#86964
* http://simplehtmldom.sourceforge.net
