 
SELECT '{"code":"' + CAST(code AS NVARCHAR(10)) + '","parentCode":"' +
       CAST(ParentCode AS NVARCHAR(10)) + '","level":"' + CAST(LEVEL AS NVARCHAR(10))
       + '","name":"' +
       NAME + '","latitude":"' +
       Latitude + '","longitude":"' +
       Longitude + '"},'
FROM   [Whir.Region]   