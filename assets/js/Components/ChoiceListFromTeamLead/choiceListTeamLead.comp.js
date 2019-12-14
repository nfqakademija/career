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
    this.props.onSetAnswers(this.props.criteriaId, choiceValue);
    this.props.onUpdateChoiceTeamLeadAnswer(this.props.criteriaId, choiceValue);
  };

  render() {
    const { choices } = this.props;
    let answer = "False";
    for (let i = 0; i < this.props.choiceList.length; i++) {
      for (let j = 0; j < choices.length; j++) {
        if (this.props.choiceList[i].choiceId === choices[j].id) {
          answer = "True";
        }
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
  managerPage: state.managerPage.selected
});

const mapDispatchToProps = dispatch => ({
  onSetAnswers: (criteriaId, choiceId) =>
    dispatch(setAnswers(criteriaId, choiceId)),
  onUpdateChoiceTeamLeadAnswer: (criteriaId, choiceId) =>
    dispatch(updateChoiceAnswerTeamLeadSide(criteriaId, choiceId))
});

export default connect(mapStateToProps, mapDispatchToProps)(ChoiceListTeamLead);
