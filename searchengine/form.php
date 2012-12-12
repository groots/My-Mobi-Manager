
<form action="page.php" method="get" id="searchBoxBG">
    <div>
        <input type="text"  name="keyword" />
        <input type="hidden" value="<?PHP echo $userName; ?>" id="u" name="u" />
        <input type="hidden" value="true" id="isSearch" name="isSearch" />
        <input type="hidden" value="<?PHP echo $siteId; ?>" id="mobileSiteId" name="mobileSiteId" />
        <input type="hidden" value="<?PHP echo $Pagetitle; ?>" id="p" name="p" />
        <input type="submit" value="Search" />
    </div>    
</form>


