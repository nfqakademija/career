import React from "react";
import { connect } from "react-redux";
import "./mountProfile.style.scss";
import { restartAnswers } from "../../Actions/action";
import CompetenceView from "../CompetenceView/competenceView.comp";
import { getUserAnswer } from "../../thunk/getUserAnswer";
import { getTeamLeadAnswer } from "../../thunk/getTeamLeadAnswer";
import { submitAnswers } from "../../thunk/submitAnswers";

class MountProfile extends React.Component {
  componentDidMount() {
    this.props.onGetUserAnswer(this.props.formId);
    this.props.onGetTeamLeadAnswer(this.props.formId);
  }

  submit = () => {
    this.props.onSubmitAnswers(
      "/api/answers",
      this.props.formId,
      this.props.answers,
      this.props.comments
    );
  };

  render() {
    if (this.props.data === 404) {
      return (
        <h1 style={{ textAlign: "center" }}>
          No Data About This Profile. Try Again Later.
        </h1>
      );
    }
    return (
      <div className="mountProfile">
        <CompetenceView
          name={this.props.name}
          position={this.props.data.profile.professionTitle}
          competence={this.props.data.profile.criteriaList}
          submit={this.submit}
        />
      </div>
    );
  }
}

const mapStateToProps = state => ({
  name: state.user.name,
  formId: state.user.formId,
  answers: state.trackUserChanges.choiceAnswers,
  comments: state.trackUserChanges.comment
});

const mapDispatchToProps = dispatch => ({
  onRestartAnswers: () => dispatch(restartAnswers()),
  onGetUserAnswer: formId => dispatch(getUserAnswer(formId)),
  onGetTeamLeadAnswer: formId => dispatch(getTeamLeadAnswer(formId)),
  onSubmitAnswers: (api, formId, answers, comments) =>
    dispatch(submitAnswers(api, formId, answers, comments))
});

export default connect(mapStateToProps, mapDispatchToProps)(MountProfile);
