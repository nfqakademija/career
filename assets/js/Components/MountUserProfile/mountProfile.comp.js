import React from "react";
import { connect } from "react-redux";
import "./mountProfile.style.scss";
import Axios from "axios";
import { restartAnswers } from "../../Actions/action";
import CompetenceView from "../CompetenceView/competenceView.comp";
import { getUserAnswer } from "../../thunk/getUserAnswer";
import { getTeamLeadAnswer } from "../../thunk/getTeamLeadAnswer";

class MountProfile extends React.Component {
  componentDidMount() {
    this.props.onGetUserAnswer(this.props.formId);
    this.props.onGetTeamLeadAnswer();
  }

  submit = () => {
    let obj = {
      formId: this.props.formId,
      choiceAnswers: this.props.answers,
      commentAnswers: this.props.comments
    };
    console.log(obj);
    if (this.props.answers.length === 0 && this.props.comments.length === 0) {
      alert("You haven't changed anything.");
    } else {
      Axios.post("/api/answers", {
        data: obj
      })
        .then(function(response) {
          alert("Created successfully");
        })
        .catch(function(error) {
          console.log(error);
          alert("Something went wrong... Try again later");
        });
      this.props.onRestartAnswers();
    }
  };

  render() {
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
  onGetTeamLeadAnswer: formId => dispatch(getTeamLeadAnswer(formId))
});

export default connect(mapStateToProps, mapDispatchToProps)(MountProfile);
