<footer class="container-fluid footer" id="help_links">
    <div class="row">
        <div class="col-sm-6">
            <div class="list-group">
                <h3 class="list-group-item list-group-item-heading">
                    {{ trans('corona.footer.title_help_links') }}
                </h3>
                <a href="https://www.mohfw.gov.in/" class="list-group-item list-group-item-action">
                    {{ trans('corona.footer.link_mohfw') }}
                </a>
                <a href="https://www.mohfw.gov.in/coronvavirushelplinenumber.pdf" class="list-group-item list-group-item-action">
                    {{ trans('corona.footer.link_mohfw_numbers') }}
                </a>
                <a href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019" class="list-group-item list-group-item-action">
                    {{ trans('corona.footer.link_who') }}
                </a>
                <a href="https://www.cdc.gov/coronavirus/2019-ncov/faq.html" class="list-group-item list-group-item-action">
                    {{ trans('corona.footer.link_cdc') }}
                </a>
                <a href="https://coronavirus.thebaselab.com/" class="list-group-item list-group-item-action">
                    {{ trans('corona.footer.link_global_tracker') }}
                </a>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="list-group">
                <h3 class="list-group-item list-group-item-heading">
                    {{ trans('corona.footer.title_sources') }}
                </h3>
                <a href="https://bit.ly/patientdb" class="list-group-item list-group-item-action">
                    {{ trans('corona.footer.link_crowdsource_db') }}
                </a>
                <a href="https://github.com/covid19india/api" class="list-group-item list-group-item-action"><i class="fab fa-1x fa-github"></i>
                    {{ trans('corona.footer.link_covid19_org') }}
                </a>
                <a href="https://forms.gle/AUg1s1sk4e1tQZ4C8" class="list-group-item list-group-item-action"><i class="fas fa-1x fa-bug"></i>
                    {{ trans('corona.footer.link_report_bug') }}
                </a>
                <a href="{{ config('app.url').'/sitemap.xml' }}" class="list-group-item list-group-item-action">
                    {{ trans('corona.footer.link_sitemap') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center text-light">
            <div class="p-3">
                {!! trans('corona.footer.link_team_tm') !!}
            </div>
        </div>
    </div>
</footer>
