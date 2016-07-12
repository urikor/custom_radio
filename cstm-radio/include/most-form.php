<form method="post">
    Statistics:
    <select id="most" name="most">
        <option value="_none">- Choose statistic -</option>
        <option value="artist">Most played artist</option>
        <option value="title">Most played song</option>
        <option value="genre">Most played music style</option>
        <option value="longest">Logest song</option>
        <option value="shortest">Shortest song</option>
    </select>
    for the
    <select id="period" name="period">
        <option value="hour">last hour</option>
        <option value="day">last day</option>
        <option value="week">last week</option>
        <option value="month">last month</option>
        <option value="year">last year</option>
    </select>
    <div id="stat-res"></div>
</form>
