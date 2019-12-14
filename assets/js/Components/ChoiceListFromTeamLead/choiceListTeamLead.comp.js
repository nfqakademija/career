import React from "react";
import { connect } from "react-redux";
import {
  setAnswers,
  updateChoiceAnswerTeamLeadSide
} from "../../Actions/action";

class ChoiceListTeamLead extends React.Component {
  onSelect = event => {
    const selectedIndex = event.target.options.selectedIndex;
    const choiceValue = event.target.options[selectedIndex].getAttribute(
      "data-value"
    );

    let answerId = null;
    for (let i = 0; i < this.props.choicesFromUser.length; i++) {
      if (this.props.choicesFromUser[i].criteriaId === this.props.criteriaId) {
        answerId = this.props.choicesFromUser[i].answerId;
      }
    }

    this.props.onSetAnswers(this.props.criteriaId, choiceValue, answerId);
    this.props.onUpdateChoiceTeamLeadAnswer(this.props.criteriaId, choiceValue);
  };

  render() {
    let answer = "False";
    for (let i = 0; i < this.props.choiceList.length; i++) {
      if (this.props.choiceList[i].criteriaId === this.props.criteriaId) {
        answer = "True";
      }
    }

    if (!this.props.managerPage) {
      return <div>{answer}</div>;
    }

    return (
      <select defaultValue={answer} onChange={this.onSelect}>
        <option value={"False"} data-value={false}>
          False
        </option>
        <option value={"True"} data-value={true}>
          True
        </option>
        ))}
        {/* {console.log(this.props.choicesFromUser)} */}
      </select>
    );
  }
}

const mapStateToProps = state => ({
  choiceList: state.answerListTeamLeadSide.choiceList,
  choicesFromUser: state.answerListUserSide.choiceList,
  managerPage: state.managerPage.selected
});

const mapDispatchToProps = dispatch => ({
  onSetAnswers: (criteriaId, choiceId, answerId) =>
    dispatch(setAnswers(criteriaId, choiceId, answerId)),
  onUpdateChoiceTeamLeadAnswer: (criteriaId, choiceId) =>
    dispatch(updateChoiceAnswerTeamLeadSide(criteriaId, choiceId))
});

export default connect(mapStateToProps, mapDispatchToProps)(ChoiceListTeamLead);
