import React from 'react';
import '../../css/Profile.style.scss';

const Profile = ({name, position, all}) =>{
    return(
        <div>

            <h5>Name: {name} Position: {position}</h5>
            {all.map((data, index) => {
                    return([
                    <h5 className="criteria" key={index}>{data.name}</h5>,
                    data.list.map((list, index) => {
                        return ([
                        <h5 className="criteriaName" key={list.criteria + index}>{list.criteria}</h5>,
                        <h5 key={list.selfEvaluation}>{list.selfEvaluation}</h5>,
                        <h5 key={list.comments}>{list.comments}</h5>,
                        <h5 key={list.teamLeadEvaluation}>{list.teamLeadEvaluation}</h5>,
                        <h5 key={list.overall}>{list.overall}</h5>
                    ])
                    })
                    ])
                }
            )}
        </div>
    )
}

export default Profile;