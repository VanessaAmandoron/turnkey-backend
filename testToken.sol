pragma solidity ^0.8.16;
// SPDX-License-Identifier: MIT
import '@openzeppelin/contracts/token/ERC20/ERC20.sol';

contract testToken is ERC20 {
  constructor() ERC20('MockToken', 'MTN') {
    _mint(msg.sender, 1000);
  }
}