import React from 'react';
import ReactDOM from 'react-dom';
import ResultsAria from './ResultsAria';
import SearchAria from './SearchAria';

const InspectionSearch = () => {
    return(
        <div className="react-wrapper">
            <SearchAria processes={PROCESSES} />
            <ResultsAria results={RESULTS} />
        </div>
    )
}

const RESULTS = [
    {
        recorded_product_number:'RN_0001',
        process_name:'工程名0001',
        form:'CHECKLIST',
        state:'未実地',
    },
    {
        recorded_product_number:'RN_0001',
        process_name:'工程名0002',
        form:'MAPPING',
        state:'未実地',
    },
    {
        recorded_product_number:'RN_0001',
        process_name:'工程名0003',
        form:'CHECKLIST',
        state:'未実地',
    },
    {
        recorded_product_number:'RN_0002',
        process_name:'工程名0001',
        form:'CHECKLIST',
        state:'未実地',
    },
    {
        recorded_product_number:'RN_0002',
        process_name:'工程名0002',
        form:'MAPPING',
        state:'未実地',
    },
    {
        recorded_product_number:'RN_0002',
        process_name:'工程名0003',
        form:'CHECKLIST',
        state:'未実地',
    },
]
const PROCESSES = [
    {
        value:'1',
        name:'工程名0001',
    },
    {
        value:'2',
        name:'工程名0002',
    },
    {
        value:'3',
        name:'工程名0003',
    }
]

if (document.getElementById('app')) {
    ReactDOM.render(<InspectionSearch />, document.getElementById('app'));
}
