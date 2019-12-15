import React from "react";
import { connect } from "react-redux";
import {
  setAnswers,
  updateChoiceAnswerTeamLeadSide,
  isActionCalled
} from "../../Actions/action";
import { checkForAnswerId } from "../../helpers/helpers";

class ChoiceListTeamLead extends React.Component {
  onSelect = event => {
    const selectedIndex = event.target.options.selectedIndex;
    let choiceValue = event.target.options[selectedIndex].getAttribute(
      "data-value"
    );
    choiceValue === 'true'? choiceValue = true : choiceValue = false;

    let answerId = checkForAnswerId(
      this.props.choicesFromUser,
      this.props.criteriaId
    );
    
    this.props.onSetAnswers(this.props.criteriaId, choiceValue, answerId);
    this.props.onUpdateChoiceTeamLeadAnswer(this.props.criteriaId, choiceValue);
    this.props.onSetChangedValues(true);
  };

  render() {
    let answer = "False";
    for (let i = 0; i < this.props.choiceList.length; i++) {
      if (
        this.props.choiceList[i].criteriaId === this.props.criteriaId &&
        this.props.choiceList[i].evaluation === true
      ) {
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
    dispatch(updateChoiceAnswerTeamLeadSide(criteriaId, choiceId)),
  onSetChangedValues: bollean => dispatch(isActionCalled(bollean))
});

export default connect(mapStateToProps, mapDispatchToProps)(ChoiceListTeamLead);
