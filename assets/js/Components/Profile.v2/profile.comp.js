import React from "react";
import "./profile.style.scss";
import ChoiceList from "../ChoiceList/choiceList.comp";
import Comments from "../Comments/comments.comp";
import ChoiceListTeamLead from "../ChoiceListFromTeamLead/choiceListTeamLead.comp";
import CommentsTeamLead from "../CommentsFromTeamLead/commentsTeamLead";

class Profile extends React.Component {
  render() {
    return (
      <div className="tablev2">
        <table>
          <thead>
            <tr>
              <th>Criteria</th>
              <th>Self Evaluation</th>
              <th>Comments</th>
              <th>Team lead evaluation</th>
              <th>Overall</th>
            </tr>
          </thead>
          <tbody>
            {this.props.criteriaList.map(criteria => {
              return (
                <tr key={criteria.id}>
                  <td data-label="Criteria">{criteria.title}</td>
                  <td data-label="Self Evaluation">
                    <ChoiceList
                      criteriaId={criteria.id}
                      choices={criteria.choiceList}
                    />
                  </td>
                  <td data-label="Comments">
                    <Comments criteriaId={criteria.id} />
                  </td>
                  <td data-label="Team lead evaluation">
                    <ChoiceListTeamLead
                      criteriaId={criteria.id}
                      choices={criteria.choiceList}
                    />
                  </td>
                  <td data-label="Overall">
                    <CommentsTeamLead criteriaId={criteria.id} />
                  </td>
                </tr>
              );
            })}
          </tbody>
        </table>
      </div>
    );
  }
}

export default Profile;
