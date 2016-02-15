Pi4D
====


Web-based, lightweight application to view Singapore's [4D lottery](http://www.singaporepools.com.sg/en/4d/htp/Pages/default.aspx) results.
Built on PHP (CodeIgniter framework).

Specifically formatted to follow Teletext colours and displayed via the Midori browser installed in Raspbian for **Raspberry Pi**. Font sizes catered for NTSC output via RCA Video-Out for older televisions.

The app uses JavaScript to automatically refresh page when the next result day has arrived.

----------
Installation
-------------

Pi4D requires no databases and only requires the cURL extension in addition to CodeIgniter installed on your web server.

The [GuzzleHTTP](https://github.com/guzzle/guzzle) library is used to communicate with the API and this is installed via Composer.

#### <i class="icon-cog"></i> Configuration

Open the configuration file loccated at  `application/config/pi4d.php`.
There, you will see two lines to configure. You must specify an API endpoint to retrieve the JSON-formatted 4D results.

#### JSON Format

The application expects the following format for the JSON input
Note that the result's date must be given in `data->result->date` in the YYYYMMDD format.
```
{  
   "result":{  
      "date":"20160214",
      "n":[  
         {  
            "i":"2660",
            "p":"1",
            "z":"T1"
         },
         {  
            "i":"5082",
            "p":"2",
            "z":"T2"
         },
         {  
            "i":"0812",
            "p":"3",
            "z":"T3"
         },
         {  
            "i":"7320",
            "p":"4",
            "z":"S1"
         },
         {  
            "i":"2087",
            "p":"5",
            "z":"S2"
         },
         {  
            "i":"0441",
            "p":"6",
            "z":"S3"
         },
         {  
            "i":"0346",
            "p":"7",
            "z":"S4"
         },
         {  
            "i":"0045",
            "p":"8",
            "z":"S5"
         },
         {  
            "i":"5013",
            "p":"9",
            "z":"S6"
         },
         {  
            "i":"2246",
            "p":"10",
            "z":"S7"
         },
         {  
            "i":"1306",
            "p":"11",
            "z":"S8"
         },
         {  
            "i":"1909",
            "p":"12",
            "z":"S9"
         },
         {  
            "i":"8194",
            "p":"13",
            "z":"S10"
         },
         {  
            "i":"0385",
            "p":"14",
            "z":"C1"
         },
         {  
            "i":"3509",
            "p":"15",
            "z":"C2"
         },
         {  
            "i":"0954",
            "p":"16",
            "z":"C3"
         },
         {  
            "i":"4550",
            "p":"17",
            "z":"C4"
         },
         {  
            "i":"0865",
            "p":"18",
            "z":"C5"
         },
         {  
            "i":"4893",
            "p":"19",
            "z":"C6"
         },
         {  
            "i":"5761",
            "p":"20",
            "z":"C7"
         },
         {  
            "i":"6571",
            "p":"21",
            "z":"C8"
         },
         {  
            "i":"9527",
            "p":"22",
            "z":"C9"
         },
         {  
            "i":"5396",
            "p":"23",
            "z":"C10"
         }
      ]
   }
}
```

> **Why such an obscure format?**
> The JSON input format is based upon existing APIs available in the Internet

-------
